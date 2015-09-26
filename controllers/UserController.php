<?php

namespace app\controllers;

use app\models\Config;
use app\models\Following;
use app\models\Likes;
use app\models\Message;
use app\models\Notification;
use app\models\NotificationTask;
use app\models\Party;
use app\models\Party2profile;
use app\models\Photo;
use app\models\SharingPhoto;
use app\models\Statistic;
use app\models\Sale;
use app\models\Ticket;
use app\models\AuthAssignment;
use app\models\UserSettings;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Auth;
use app\models\User;
use app\models\UserNotification;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use MetzWeb\Instagram\Instagram;

use AuthorizeNetAIM;
use AuthorizeNet_Subscription;
use AuthorizeNetARB;

if(YII_ENV === 'prod'){
    define("AUTHORIZENET_API_LOGIN_ID", "4YBsRE4q4L7y");
    define("AUTHORIZENET_TRANSACTION_KEY", "2tLSy8SKD223m8DH"); //Simon
    define("AUTHORIZENET_MD5_SETTING", "9414l!fe");
    define("AUTHORIZENET_SANDBOX", false);
} else{
    define("AUTHORIZENET_API_LOGIN_ID", "5s3FZ3Wrm");
    define("AUTHORIZENET_TRANSACTION_KEY", "2VXwr6zrMJ2936Kb"); //Simon
    define("AUTHORIZENET_MD5_SETTING", "muhit");
    define("AUTHORIZENET_SANDBOX", true);
}



class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionProfile()
    {
        $id = Yii::$app->user->getId();
        $model = User::find()->where(['id' => $id, 'status' => User::STATUS_ACTIVE])->one();
        if(!$model instanceof User)
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if($model->is_full_filled()){
            $this->redirect(Url::to(['/member/qt'.$id]));
        }

        $model->scenario = 'find';

        if (!isset(Yii::$app->request->cookies['countView'.Yii::$app->user->getId()])) {
            if(Statistic::countPlusOne(Yii::$app->user->getId(), Statistic::TYPE_PROFILE_VIEWS)){
                Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'countView'.Yii::$app->user->getId(),
                    'value' => 'true',
                    'expire' => time() + 60*60 //60 minute
                ]));
            }
        }
        return $this->render('base_profile', ['model' => $model]);
    }

    public function actionUpdateAvatar()
    {
        $id = Yii::$app->user->getId();
        $model = User::find()->where(['id' => $id, 'status' => User::STATUS_ACTIVE])->one();
        if(!$model instanceof User)
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->scenario = 'find';

        if($model->load(Yii::$app->request->post()))
        {
            $model->loadPhoto('avatar');
            if($model->save()) {
                NotificationTask::addUpdateProfile(Yii::$app->user->getId());
                $this->redirect(Url::to('/user/profile'));
            }
        }

        return $this->renderAjax('update-avatar', ['model' => $model]);
    }

    public function actionInstagramToken(){
        $code = $_GET['code'];
        $instagram = $this->getInstagram();
        $data = $instagram->getOAuthToken($code);
        $id = Yii::$app->user->getId();
        $model = User::find()->where(['id' => $id])->one();
        $model->instagram_token = $data->access_token;
        $model->instagram_user_id = $data->user->id;
        $model->scenario = 'instagram';
        if($model->save()){

        }
        echo '<script>window.close();</script>';

    }
    private function getInstagram(){
        $redirectUrl = Yii::$app->params['domen'].\yii\helpers\Url::to(['/user/instagram-token']);

        return  new Instagram(array(
            'apiKey'      => Yii::$app->params['instagramApiKey'],
            'apiSecret'   => Yii::$app->params['instagramApiSecret'],
            'apiCallback' => $redirectUrl
        ));

    }
    public function actionInstagramPhotos(){
        $id = Yii::$app->user->getId();
        $model = User::find()->where(['id' => $id])->one();
        $instagram = $this->getInstagram();
        if(!$model->instagram_token){
            return $this->renderAjax('instagram_photos',['model' => $model, 'instagramtUrl' => $instagram->getLoginUrl()]);
        }else{
            $images = $instagram->getUserMedia($model->instagram_user_id, 1000);
            return $this->renderAjax('instagram_photos',['model' => $model, 'images' => $images]);
        }

    }
    public function actionSaveInstagramImage(){
        if($post = Yii::$app->request->post()){
            $userId = Yii::$app->user->getId();
            $photo = new Photo();
            $photo->party_id = ($post['type'] === 'party')? $post['key'] : 0;
            $photo->load_user_id = $userId;
            $photo->created_at = time();
            $photo->loadInstagramPhoto($post['image'], 'image');
            if($photo->save()){
                if($post['type'] === 'user' && $user = User::find()->where(['id' => $userId])->one()){
                    $user->$post['key'] = $photo->image;
                    $user->{$post['key'].'_id'} = $photo->id;
                    $user->scenario = $post['key'];
                    $user->save();
                    if($post['key'] === 'avatar'){
                        $photo->delete();
                    }
                }
                if($post['type'] === 'party'){
                    if(!$party2Profile = Party2profile::findOne(['user_id' => $userId, 'party_id' => $post['key']])){
                        $party2Profile = new Party2profile();
                        $party2Profile->user_id =  $userId;
                        $party2Profile->party_id =  $post['key'];
                        $party2Profile->created_at =  time();
                        $party2Profile->save();
                    }
                }
                NotificationTask::addPhoto(Yii::$app->user->getId());
            }

            echo json_encode(array('success'));
        }
    }
    public function actionUpdate()
    {
        $id = Yii::$app->user->getId();
        $model = User::find()->where(['id' => $id, 'status' => User::STATUS_ACTIVE])->one();
        if(!$model instanceof User)
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->scenario = 'find';

        if($model->load(Yii::$app->request->post()))
        {
                $love = [];
            if(isset(Yii::$app->request->post('User')['love'])) {
                $love = array_filter(Yii::$app->request->post('User')['love'], function ($el) {
                    return !empty($el);
                });
            }
                if (Yii::$app->request->post('love-custom-val'))
                    $love[] = Yii::$app->request->post('love-custom-val');
                if (Yii::$app->request->post('love-custom-val2'))
                    $love[] = Yii::$app->request->post('love-custom-val2');
                if (Yii::$app->request->post('love-custom-val3'))
                    $love[] = Yii::$app->request->post('love-custom-val3');

                $model->love = implode('#$%', $love);

            if(isset(Yii::$app->request->post('User')['work']))
            {
                $variantNumber = Yii::$app->request->post('User')['work'];
                if($variantNumber == 10)
                    $variantValue = Yii::$app->request->post('work_description')[$variantNumber].'#'.Yii::$app->request->post('custom-work');
                else $variantValue = Yii::$app->request->post('work_description')[$variantNumber];
                if(!empty($variantValue)){
                    $model->work = implode('#', [$variantNumber, $variantValue]);
                }
            }
            $images = array('photo1', 'photo2', 'photo3', 'photo4', 'photo5');
            foreach($images as $image){
                if(file_exists($_FILES['User']['tmp_name'][$image])){
                    $model->loadPhoto($image);
                }

            }

            if($model->save())
            {
                NotificationTask::addUpdateProfile(Yii::$app->user->getId());

                if (! Yii::$app->request->isAjax)
                    return $this->redirect(Url::to('/user/profile'));
            }
        }

        $usersProfilePhoto = Photo::findProfilePhoto(Yii::$app->user->getId());

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_update_profile',['model' => $model, 'profilePhotos' => $usersProfilePhoto]);
        }
        else return $this->render('_update_profile',['model' => $model, 'profilePhotos' => $usersProfilePhoto]);
    }

    public function actionDeletePhoto($id)
    {
        if(is_numeric($id) && $id>=1 && $id<=4)
        {
            $model = User::find()->where(['id' => Yii::$app->user->getId(), 'status' => User::STATUS_ACTIVE])->one();
            $model->scenario = 'edit';
            if($model instanceof User) {
                $photoName = 'photo' . $id;
                $model->removePhoto($model->$photoName);
                $model->$photoName = '';
                $model->save();
                echo 'Photo deleted';
            }
        }
    }

    public function actionSingupFromFacebook()
    {
        $id = Yii::$app->user->getId();
        $model = User::find()->where(['id' => $id, 'status' => User::STATUS_SING_UP_FROM_FACEBOOK])->one();

        if($model->load(Yii::$app->request->post())){
            $model->load(Yii::$app->request->post());
            $model->setPassword($model->password);
            $model->loadPhoto('avatar');
            $model->setAdressByZipCode(Yii::$app->request->post('User')['zip_code']);
            $model->status = User::STATUS_ACTIVE;
            if($model->save()){
                //отправка welcome письма
                $welcomeLetter = new Message([
                    'user_from' => 0,
                    'user_to' => Yii::$app->user->getId(),
                    'created_at' => time(),
                    'text' => Config::getValue('mainPage', 'welcome_letter')
                ]);
                if($welcomeLetter->save())
                {
                    $welcomeLetter->createNotification();
                }
                $this->redirect(Url::to(['user/profile']));
            }
        }

        return $this->render('singup-from-facebook', ['model' => $model]);
    }

    public function actionFollow($id)
    {
        $follow = new Following(
            ['follow_to' => $id,
             'user_id' => Yii::$app->user->getId(),
             'created_at' => time()
            ]);
        $follow->save();
        $this->redirect(Url::to(['/site/member/', 'id' => 'qt'.$id]));
    }

    public function actionSendMail($id)
    {
        $userTo = $this->findModel($id, 'app\models\User');
        $model = new Message([
                'user_from' => Yii::$app->user->getId(),
                'user_to' => $id,
                'created_at' => time()
            ]);

        if($model->load(Yii::$app->request->post()) && $model->save())
        {
            $model->createNotification();
            return 'Message has been sent';
        }

        return $this->renderPartial('send-email-form',
            ['userTo' => $userTo,
             'user' =>  $this->findModel(Yii::$app->user->getId(), 'app\models\User'),
             'model' => $model
            ]
        );
    }

    public function actionUpload($id)
    {
        $photo = New Photo();
        $photo->load_user_id = Yii::$app->user->getId();
        $photo->status = 0; //не проверено
        $photo->party_id = $id;
        $photo->created_at = time();
        $photo->image = $photo->loadPhoto('photo');
        $image = UploadedFile::getInstanceByName('photo');
        $commentfiledName = preg_replace('/(\.|\s+)/', '_', $image->name);
        $photo->comment = Yii::$app->request->post($commentfiledName, '');
        if($photo->save())
        {
            SharingPhoto::share($photo, "", SharingPhoto::TYPE_PARTY);
            return json_encode(['status' => 'success']);
        }
        else
            return json_encode(['status' => 'error']);
    }

    /******************  Likes & Share  ****************/

    public function actionLike($id)
    {
        $photoID =  $id;
        if(strpos($id, 'u') === false)
        {
            //фото с пати
            $this->likeIfNotLiked($id);
            $photo = $this->findModel($id, '\app\models\Photo');
            return $this->renderAjax('/site/_photo', [
                'photo' => $photo,
                'likes' => Likes::getLikes($photo->id),
                'userId' => Yii::$app->user->getId(),
                'user' => $user = User::findOne(Yii::$app->user->getId()),
                'shares' => SharingPhoto::getShares($photo->id)
            ]);
        }
        else
        {
            //для user profile photo
            $userPhotoId = explode('u', $id);

            $user = User::findOne($userPhotoId[0]);
            $photoNum = $userPhotoId[1];
            if(!$user instanceof User || !is_numeric($photoNum) || $photoNum<1 || $photoNum>4)
            {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
            $photo = 'photo'.$photoNum;
            $this->likeIfNotLiked($photoID);
            return $this->renderAjax('/site/_user_photo', [
                'id' => $photoID,
                'image' => $user->{$photo},
                'likes' => Likes::getLikes($photoID),
                'user' => $user
            ]);
        }
    }

    public function likeIfNotLiked($photoID)
    {
        if(!Likes::is_liked($photoID))
        {
            $newLike = new Likes();
            $newLike->created_at = time();
            $newLike->photo_id = $photoID;
            $newLike->user_id = Yii::$app->user->getId();
            $newLike->save();
        }
    }

    public function actionSharePhoto($id)
    {
        $photo = $this->findModel($id, '\app\models\Photo');
        if($photo->allow2sharing && !SharingPhoto::is_share($photo->id))
        {
            $comment = Yii::$app->request->post('comment');
            SharingPhoto::share($photo, $comment);
        }

        $this->redirect(Url::to(['site/photo/', 'id' => $id]));
    }

    public function actionShareParty($id)
    {
        if(!Party2profile::is_shared($id, Yii::$app->user->getId()))
        {
            Party2profile::share($id, Yii::$app->user->getId());
        }

        $this->redirect(Url::to(['/user/profile']));
    }

    /******************  Dashboard  ****************/

    public function actionDashboard()
    {
        $user = User::findOne(Yii::$app->user->getId());
        $userId = $user->id;
        //$where = "user_id = $userId or user_id like '$userId#%' or  user_id like '%#$userId#%' or  user_id like '%#$userId'";
        $notification941 = Notification::find()->where("user_id = $userId and type = 0")->orderBy('created_at DESC')->all();
        $notifications = NotificationTask::find()
            ->where("type in (2,3,4) and find_in_set($userId, replace(user_list, '#', ','))")
            ->with('profileUpdate')
            ->with('photoUpdate')
            ->with('user')
            ->orderBy('id DESC')->all();
        $memberNotification = [];

        foreach($notifications as $notification){
            if(!isset($memberNotification[$notification->user->id])){
                $memberNotification[$notification->user->id] = array('user' => $notification->user);
                $memberNotification[$notification->user->id]['notifications'] = array();
            }
            $memberNotification[$notification->user->id]['notifications'][] = $notification;
        }
        $notification = Notification::getMessageNotifications($userId);
        $Messages = Message::getAllMessages($userId);

        $parties = Party::find()
            ->with([
                'photo' => function ($query) {
                    $query->where('photo.deleted_party =0 or photo.deleted_party is NULL')
                        ->orderBy('photo.view_count DESC');
                },
                'sales' => function ($query) {
                    $query->with(['ticket'])->where(['<=', 'sale.started_at', time()])
                        ->andWhere(['>=', 'sale.finished_at', strtotime("-2 day 00:00:00")])
                        ->orderBy('sale.started_at DESC');
                },
                'party2profile' => function($query)
                {
                    $query->joinWith('user')
                        ->orderBy('user.rank DESC');
                }]
        )->all();

        if(Yii::$app->request->post('re_id'))
        {
            $message = new Message([
                're_id' => Yii::$app->request->post('re_id'),
                'user_from' => Yii::$app->user->getId(),
                'user_to' => Yii::$app->request->post('user_from'),
                'text' => Yii::$app->request->post('answer'),
                'status' => Message::STATUS_NEW,
                'created_at' => time()
            ]);
            if($message->save())
            {
                Yii::$app->getSession()->setFlash('success', Yii::t('yii','Message send success'));
                $message->createNotification();
                return $this->refresh();
            }
        }

        $myTickets  = Ticket::find()
            ->joinWith('party')
            ->with('user', 'detail')
            ->where(['user_id' => Yii::$app->user->getId()])
            ->andWhere(['>=', 'party.finished_at', strtotime("-2 day 00:00:00")])
            ->all();

        $partyTickets = [];
        foreach($myTickets as $ticket){
            if(!isset($partyTickets[$ticket->party_id])){
                $partyTickets[$ticket->party_id] = [];
                $partyTickets[$ticket->party_id]['party'] = $ticket->party;
                $partyTickets[$ticket->party_id]['tickets'] = [];
            }
            $partyTickets[$ticket->party_id]['tickets'][] = $ticket;
        }

        $flashMessages = Yii::$app->session->getAllFlashes();

        return $this->render('dashboard',
            [
                'user' => $user,
                'parties' => $parties,
                'parties' => $parties,
                'messages' => $Messages,
                'myTickets' => $myTickets,
                'partyTickets' => $partyTickets,
                'notification' => $notification,
                'flashMessages' => $flashMessages,
                'notification941' => $notification941,
                'memberNotification' => $memberNotification
            ]
        );
    }

    /******************  Settings  ****************/
    public function actionSettings()
    {
        $settings = [
            'credit_card_number' => 'Credit card number',
            'billing_adress' => 'Billing address'
        ];

        if(Yii::$app->request->post())
        {
            foreach($settings as $key=>$value)
            {
                UserSettings::saveValue(Yii::$app->user->getId(), $key, Yii::$app->request->post($key));
            }
            $this->refresh();
        }
        return $this->render('settings',
            [
                'settings' => $settings,
                'user' => User::find()->where(['id' => Yii::$app->user->getId()])->one(),
            ]
        );
    }

    /******************  Ticket   ****************/

    public function actionTickets()
    {
        $myTickets  = Ticket::find()
            ->joinWith('party')
            ->with('user', 'detail')
            ->where(['user_id' => Yii::$app->user->getId()])
            ->all();

        $partyTickets = [];
        foreach($myTickets as $ticket){
            if(!isset($partyTickets[$ticket->party_id])){
                $partyTickets[$ticket->party_id] = [];
                $partyTickets[$ticket->party_id]['party'] = $ticket->party;
                $partyTickets[$ticket->party_id]['tickets'] = [];
            }
            $partyTickets[$ticket->party_id]['tickets'][] = $ticket;
        }


        return $this->render('tickets', [
            'user' => User::find(['id' => Yii::$app->user->getId()])->one(),
            'partyTickets' => $partyTickets
        ]);
    }



    /******************  Base method  ****************/

    protected function findModel($id, $class)
    {
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function deleteAndRedirect($id, $model, $redirectAfterDelete)
    {
        $this->findModel($id, $model)->delete();
        return $this->redirect(Url::toRoute($redirectAfterDelete));
    }
    public function actionReply(){
        if($post = Yii::$app->request->post()){
            $message = new Message();
            $message->text = $post['text'];
            $message->user_to = $post['user_to'];
            $message->user_from = Yii::$app->user->getId();
            $message->created_at = time();
            $message->save();
            print_r($post);
        }
    }

    public function actionUnpremium()
    {
        if(!(Yii::$app->user->can('premium'))){
            Yii::$app->session->addFlash('success', 'Your are not premium');
            $this->redirect(Url::to(['/user/dashboard']));
            return $this->actionDashboard();
        }

        if($authAssignment = AuthAssignment::find()->where(['item_name' => 'premium','user_id' =>Yii::$app->user->getId()])->one()){
            $authAssignment->delete();
        }

        if($user = User::find()->where(['id' =>Yii::$app->user->getId()])->one()){
            $user->scenario = 'premium';
            $user->premium_status = -1;
            $user->premium_end_date = time();
            $user->save();
            $request  = new AuthorizeNetARB;
            $request->cancelSubscription($user->subscription_id);
        }
        echo  $this->render('unpremium');
    }
    /**
     *
     */
    public function actionPremiumMonthly()
    {
        $amount =  10;
        $description = 'Monthly Premium membership @10';
        return $this->buyPremium('monthly', $amount, $description);
    }

    /**
     *
     */
    public function actionPremiumAnnual()
    {
        $amount = 50;
        $description = 'Annual Premium membership @50';
        return $this->buyPremium('annual', $amount, $description);

    }
    private function buyPremium($type, $amount, $description)
    {
        if(Yii::$app->user->can('premium')){
            Yii::$app->session->addFlash('success', 'Your are already premium');
            $this->redirect(Url::to(['/user/dashboard']));
        }

        $user = User::find()->where(['id' =>Yii::$app->user->getId()])->one();
        $errorMessage = '';
        if($data = Yii::$app->request->post()){
            $sale           = new AuthorizeNetAIM;
            $sale->amount   = $amount;
            $sale->card_num = $data['card_num'];
            $sale->card_code = $data['card_code'];
            $sale->address = $data['address'];
            $sale->city = $data['city'];
            $sale->zip = $data['zip'];
            $sale->state = $data['state'];
            $sale->exp_date = $data['exp_date'];
            $sale->first_name = $data['first_name'];
            $sale->last_name = $data['last_name'];
            $sale->email = $user->email;
            $sale->description = $description;
            $response = $sale->authorizeAndCapture();
            if ($response->approved) {

                $auth = new AuthAssignment();
                $auth->item_name = 'premium';
                $auth->user_id = $user->id;
                $auth->created_at = time();
                $auth->save();

                $user->scenario = 'premium';
                $user->premium_status = 1;
                $user->premium_type = 1;
                $user->subscription_type = $type;
                $user->premium_start_date = time();
                $user->transaction_id = $response->transaction_id;
                $user->subscription_id = $this->subscribe($type, $amount, $description, $data);

                if($user->save()){
                    Yii::$app->session->addFlash('success', 'Enjoy! You are premium now.');
                }
                else{
                    Yii::$app->session->addFlash('success', 'Your are paid! Please contact admin to have you premium');
                }
                $this->redirect(Url::to(['/user/dashboard']));
                return $this->actionDashboard();
            }
            $errorMessage =  isset($response->response_reason_text)? $response->response_reason_text : @$response->error_message;
        }
        return $this->render('BuyPremiumPage', [
            'user' => $user,
            'type' => $type,
            'amount' => $amount,
            'errorMessage' => $errorMessage,
        ]);
    }
    private function subscribe($type, $amount, $description, $data)
    {

        $user = User::find()->where(['id' =>Yii::$app->user->getId()])->one();

        $intervalLength = ($type === 'annual') ? '12' : '7';
        $totalOccurrences = ($type === 'annual') ? '5' : '60';
        $startDate = ($type === 'annual') ? '+1 year' : '+1 month';
        $intervalUnit = 'months';

        $intervalUnit = 'days';$intervalLength = '7'; //@todo: Remove it next week.

        $subscription                           = new AuthorizeNet_Subscription;
        $subscription->name                     = $description;
        $subscription->intervalLength           = $intervalLength;
        $subscription->intervalUnit             = $intervalUnit;
        $subscription->startDate                = date('Y-m-d', strtotime($startDate));
        $subscription->totalOccurrences         = $totalOccurrences;
        $subscription->amount                   = $amount;
        $subscription->creditCardCardNumber     = $data['card_num'];
        $subscription->creditCardExpirationDate = $data['exp_date'];
        $subscription->creditCardCardCode       = $data['card_code'];
        $subscription->billToFirstName          = $data['first_name'];
        $subscription->billToLastName           = $data['last_name'];
        $subscription->customerEmail                    = $user->email;
        $subscription->billToAddress            = $data['address'];
        $subscription->billToCity               = $data['city'];
        $subscription->billToState              = $data['state'];
        $subscription->billToZip                = $data['zip'];
        $subscription->billToCountry            = 'US';

        $request         = new AuthorizeNetARB;
        $response = $request->createSubscription($subscription);
        return $response->getSubscriptionId();

    }
    public function actionPrintTicket(){
        $partyId = @$_GET['party_id'];
        $ticketId = @$_GET['ticket_id'];
        $userId = Yii::$app->user->getId();
        $tickets = Ticket::find()
            ->with('party', 'user', 'detail')
            ->where(['party_id' => (int) $partyId, 'user_id' => (int)$userId]);
        if($ticketId){
            $tickets->andWhere(['id' =>(int)$ticketId]);
        }
        $tickets = $tickets->all();

        echo  $this->renderPartial('print_tickets', [
            'partyTickets' => $tickets,
        ]);
    }
}
