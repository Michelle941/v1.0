<?php

namespace app\controllers;

use app\models\Config;
use app\models\Form;
use app\models\Likes;
use app\models\Message;
use app\models\NotificationTask;
use app\models\Page;
use app\models\Party;
use app\models\Party2profile;
use app\models\Photo;
use app\models\SharingPhoto;
use app\models\Statistic;
use app\models\Ticket;
use app\models\TicketType;
use app\models\Payment;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Auth;
use app\models\User;
use yii\web\NotFoundHttpException;
use yii\base\ActionEvent;
use MetzWeb\Instagram\Instagram;

use AuthorizeNetAIM;

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

class SiteController extends Controller
{
    public  $loginForm, $newUserModel;

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_ACTION, function(ActionEvent $event) {
            if (in_array($event->action->id, ['response'])) {
                $this->enableCsrfValidation = false;
            }
        });
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        //Login form
        $this->loginForm = new LoginForm();

        //Join step 2
        $this->newUserModel = new User();
        $this->newUserModel->status = User::STATUS_EMAIL_NOT_CONFIRM;
        $this->newUserModel->created_at = $this->newUserModel->updated_at = time();
        $this->newUserModel->generatePasswordResetToken();

        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();

        /** @var Auth $auth */
        $auth = Auth::find()->where([
                'source' => $client->getId(),
                'source_id' => $attributes['id'],
            ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                $user = $auth->user;
                //last login
                Yii::$app->user->login($user);
            } else { // signup
                if (User::find()->where(['email' => $attributes['email']])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $client->getTitle()]),
                        ]);
                } else {
                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'status' => User::STATUS_SING_UP_FROM_FACEBOOK,
                        'email' => $attributes['email'],
                        'password' => $password.'1qQ',
                        'created_at' => time(),
                        'gender' => ($attributes['gender'] == 'female') ? 1 : 0,
                        'name'  => $attributes['first_name'],
                        'last_name' => $attributes['last_name']
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();
                    if ($user->save()) {
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $client->getId(),
                            'source_id' => (string)$attributes['id'],
                        ]);
                        $auth->save();
                        Yii::$app->user->login($user);
                    } else {
                        print_r($user->getErrors());
                    }
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                ]);
                $auth->save();
            }
        }
    }

    public function actionIndex()
    {
        $query = Party::searchNew($_GET)->orderBy('rank')->limit(6);
        $query->with([
                'photo' => function ($query) {
                    $query->where('photo.deleted_party =0 or photo.deleted_party is NULL')
                        ->orderBy('photo.view_count DESC');
                },
                'sale' => function ($query) {
                    $query->where(['<=', 'sale.started_at', time()]);
                    $query->andWhere(['>=', 'sale.finished_at', time()]);},
                'party2profile' => function($query)
                {
                    $query->joinWith('user')
                        ->orderBy('user.rank')
                        ->limit(8);
                }]
        );

        $party = $query->all();
        $countAll = $query->count();

        return $this->render('parties', [
            'parties' => $party,
            'is_last' => ($countAll <= 6)
        ]);

        if (!Yii::$app->user->isGuest) {
            $user = User::findOne(Yii::$app->user->getId());
            if($user->status == User::STATUS_SING_UP_FROM_FACEBOOK)
                $this->redirect(Url::to(['/user/singup-from-facebook']));
        }
        return $this->render('index');
    }

    public function actionLogin()
    {
        $model = $this->loginForm;
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Url::to('/user/profile'));
        }
        $this->loginForm->password = '';
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH'] )){
            return $this->renderAjax('_loginForm');
        }
        return $this->render('index', ['loginForm' => true]);
    }

    public function actionPage($id)
    {
        if(in_array($id, array('about', 'contact', 'how-it-works'))){
            return $this->render('about', ['title' => $id]);
        }

        $page = Page::find()->where(['url' => $id])->one();
        if(!$page instanceof Page)
            throw new NotFoundHttpException('The requested page does not exist.');
        return $this->render('page', ['page' => $page]);
    }

    public function actionMembers()
    {
        $popularMembers = User::find()
            ->orderBy('view_count DESC')
            ->where(['rank' => 1])
            ->andWhere(['status' => 10])
            ->limit(8)
            ->asArray()
            ->all();

        $newMembers = User::find()
            ->orderBy('created_at DESC')
            ->where(['rank' => 2])
            ->andWhere(['status' => 10])
            ->limit(12)
            ->asArray()
            ->all();

        $this->saveViewedProfile(array_merge($popularMembers, $newMembers));

        $members = User::find()
            ->orderBy('rank ASC')
            ->where('id not in ('.$this->getViewedMemberIds().')')
            ->andWhere(['status' => 10])
            ->limit(12)
            ->asArray()
            ->all();

        $countAll = User::find()
            ->where('id not in ('.$this->getViewedMemberIds().')')
            ->count();

        return $this->render('members', [
            'popularMembers' => $popularMembers,
            'newMembers' => $newMembers,
            'members' => $members,
            'is_last' => ($countAll <= 20)
        ]);
    }
    private function saveViewedProfile($members){
        $session = Yii::$app->session;
        $memberIds = array();
        foreach($members as $member){
            $memberIds[] = $member['id'];
        }
        $session->set('memberIds', implode(',', $memberIds));
    }
    private function getViewedMemberIds(){
        $session = Yii::$app->session;
        if($members = $session->get('memberIds')){
            return $members;
        }
        return '-1';
    }

    public function actionLoadMoreUser($pages)
    {
        $members = User::find()
            ->orderBy('rank ASC')
            ->where('id not in ('.$this->getViewedMemberIds().')')
            ->andWhere(['status' => 10])
            ->offset($pages)
            ->limit(24)
            ->asArray()->all();

        $countAll = User::find()
            ->where('id not in ('.$this->getViewedMemberIds().')')
            ->andWhere(['status' => 10])
            ->count();

        $jsonResult = [
            'html' => $this->renderPartial('_small_members_block', [
                'members' => $members
            ]),
            'last' => ($countAll < ($pages + 24))
        ];
        echo json_encode($jsonResult);
    }

    public function actionGetUsers($term)
    {
        $userModel = new User();
        $memberSearch = $userModel->search();
        $memberSearch->select(['Concat(user.name, " ",user.last_name) as value, user.id']);
        $memberSearch->andFilterWhere(['or', ['like', 'name', $term], ['like', 'last_name', $term]]);
        $memberSearch->orderBy('name');
        $memberSearch = $memberSearch->asArray()->all();

        echo json_encode($memberSearch);
    }

    public function actionSearch()
    {
        $userModel = new User();

        if(Yii::$app->request->get('search'))
        {
            $term = Yii::$app->request->get('search');
            $memberSearch = $userModel->search();
            $memberSearch->andFilterWhere(['or', ['like', 'name', $term], ['like', 'name', $term]]);
            $memberSearch->orderBy('view_count DESC');
            $members = $memberSearch->asArray()->all();
        }
        else {
            $members = $userModel->search();
            $members->orderBy('view_count DESC');
            $members = $members->asArray()->all();
            $term = 'Empty search string';
        }

        return $this->render('members_searched', [
            'members' => $members,
            'is_last' => true,
            'search_string' => $term
        ]);
    }

    public function actionMember($id)
    {
        preg_match('/qt(\d+)/', $id, $userID);
        $id = isset($userID[1]) ? $userID[1] : $id;

        $currentUserId = Yii::$app->user->getId();
        $user =  $this->findModel($id, 'app\models\User');

        if($currentUserId == $id && !$user->is_full_filled()){
            $this->redirect(Url::to(['user/profile']));
        }

        if (!isset(Yii::$app->request->cookies['countView'.$user->id])) {
            if(Statistic::countPlusOne($user->id, Statistic::TYPE_PROFILE_VIEWS)){
                Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'countView'.$user->id,
                    'value' => 'true',
                    'expire' => time() + 60*10 //10 minute
                ]));
                $user->scenario = 'view_count';
                $user->view_count +=1;
                $user->save();
            }
        }

        $newPhotos  = Photo::getUserNewPhotos($id, 0, 3); // первые 5 фоток
        $newPhotoId = [];
        foreach($newPhotos as $photo){
            $newPhotoId[] =  $photo->id;
        }
        $newPhotoId = implode(',', $newPhotoId);

        $popularPhotos  = Photo::getPhotos($id, 0, 2, $newPhotoId); // первые 5 фоток
        $photos  = Photo::getPhotos($id, 2, 10000, $newPhotoId); // первые 5 фоток
        $usersParty = Party2profile::find()->where(['user_id' => $id])->all();
        $highlightedParties = Party::find()->where(['highlight' => 1])->limit(6)->all();
        $highlightedParty = false;
        if($currentUserId == $id && empty($usersParty)){
            $highlightedParty = true;
        }
        $highlighed = false;

        $photoCount  = Photo::getPhotoCounts($id, $newPhotoId);
        $partyCount  =  Party2profile::countByUser($id);
        $highlightedPhoto = [];
        $highlightedPhoto[] = @$newPhotos[0];
        $highlightedPhoto[] = @$popularPhotos[1];
        $highlightedPhoto[] = @$newPhotos[1];
        $highlightedPhoto[] = @$newPhotos[2];
        $highlightedPhoto[] = @$popularPhotos[0];

        return $this->render('publicProfile', [
            'user' => $user,
            'highlightedPhoto' => $highlightedPhoto,
            'photos' => $photos,
            'usersParty' => $usersParty,
            'highlightedParties' => $highlightedParties,
            'highlightedParty' => $highlightedParty,
            'newPhotoId' => $newPhotoId,
            'highlighed' => $highlighed,
            'hasMorePhoto' => ($photoCount > 10000),
            'hasMoreParties' => ($partyCount > 3)
        ]);
    }

    public function actionLoadUserPhotos($id, $pages)
    {
        $photos  = Photo::getPhotos($id, $pages, 6, $_GET['newPhotoId']);
        $countAll  = Photo::getPhotoCounts($id, $_GET['newPhotoId']);

        $jsonResult = [
            'html' => $this->renderPartial('_photos', [
                'photos' => $photos
            ]),
            'last' => ($countAll < ($pages + 6))
        ];
        echo json_encode($jsonResult);
    }

    public function actionLoadUserParties($id, $pages)
    {
        $sharedPhotos = Party2profile::findByUser($id, $pages+2, 6); // еще 12 пати
        $countAll = Party2profile::countByUser($id);

        $jsonResult = [
            'html' => $this->renderPartial('_user_shared_party', [
                'parties' => $sharedPhotos
            ]),
            'last' => ($countAll < ($pages+2 + 6))
        ];
        echo json_encode($jsonResult);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionPhoto($id)
    {
        $photo = Photo::find()
            ->where(['id' => $id])
            ->with('user', 'share', 'party')
            ->one();

        if (!isset(Yii::$app->request->cookies['countPhotoView'.$photo->id])) {
            if(Statistic::countPlusOne($photo->id, Statistic::TYPE_PHOTO_VIEWS)){
                Yii::$app->getResponse()->getCookies()->add(new \yii\web\Cookie([
                        'name' => 'countPhotoView'.$photo->id,
                        'value' => '1',
                        'expire' => time() + 60*60 //60 minute
                    ]));
                $photo->view_count += 1 ;
                $photo->save();
            }
        }
        return $this->renderAjax('_photo', [
            'photo' => $photo,
            'likes' => Likes::getLikes($photo->id),
            'userId' => Yii::$app->user->getId(),
            'user' => $user = User::findOne(Yii::$app->user->getId()),
            'shares' => SharingPhoto::getShares($photo->id)
        ]);
    }

    public function actionUserPhoto($id, $photoNum)
    {
        $user = User::findOne($id);
        if(!$user instanceof User || !is_numeric($photoNum) || $photoNum<1 || $photoNum>4)
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (!isset(Yii::$app->request->cookies['countPhotoView'.$id.'u'.$photoNum])) {
            if(Statistic::countPlusOne($id.'u'.$photoNum, Statistic::TYPE_PHOTO_VIEWS)){
                Yii::$app->getResponse()->getCookies()->add(new \yii\web\Cookie([
                    'name' => 'countPhotoView'.$id.'u'.$photoNum,
                    'value' => '1',
                    'expire' => time() + 60*10 //10 minute
                ]));
            }
        }

        $photo = 'photo'.$photoNum;

        return $this->renderAjax('_user_photo', [
            'id' => $id.'u'.$photoNum,
            'image' => $user->{$photo},
            'likes' => Likes::getLikes($id.'u'.$photoNum),
            'user' => $user
        ]);
    }

    public function actionLoadMoreLike($id, $pages)
    {
        $likes = Likes::find()
            ->where(['photo_id' => $id])
            ->with('user')
            ->offset($pages)
            ->limit(6)
            ->all();
        echo $this->renderPartial('_social_photo_part', ['shares' => $likes]);
    }

    public function actionLoadMoreShare($id, $pages)
    {
        $share = SharingPhoto::find()
            ->where(['obj_id' => $id])
            ->with('user')
            ->offset($pages)
            ->limit(6)
            ->all();
        echo $this->renderPartial('_social_photo_part', ['shares' => $share]);
    }

    /******************  Join   ****************/

    public function actionJoin()
    {
        if($data = Yii::$app->request->post() ){
            //Let incomplete registration complete
            if(!$model = User::findOne(['email' => $data['User']['email'], 'status' => User::STATUS_EMAIL_NOT_CONFIRM])){
                $model = $this->newUserModel;
            }
            $model->load($data);
            $model->setPassword($data['User']['password']);

            if($model->save()){
                return $this->renderAjax('complete', [
                    'model' => $model,
                ]);
            }
            else {
                return $this->renderAjax('_joinForm');
            }
        }
    }

    public function actionJoinStep2()
    {
        $model = User::find()->where(['id' => Yii::$app->request->post('User')['id']])->one();
        $model->scenario = 'step2';
        if(!$model instanceof User)
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->load(Yii::$app->request->post());
        $model->loadPhoto('avatar');
        $model->setAdressByZipCode(Yii::$app->request->post('User')['zip_code']);

        if((! $model->save()) or (empty($model->avatar)) or (empty($model->city))) {
            if(empty($model->avatar))
                $model->addError('avatar', 'Upload your photo');
            if(empty($model->city))
                $model->addError('zip_code', 'Enter valid zip code');
            $model->undoConvertedDOB();
            return $this->renderAjax('complete', [
                'model' => $model,
            ]);
        }
        $model->scenario = 'step3';

        return $this->renderAjax('preview', ['model' => $model]);
    }
    public function actionJoinInstagram()
    {
        $model = User::find()->where(['id' => Yii::$app->request->post('User')['id']])->one();
        $model->scenario = 'step2';
        if(!$model instanceof User)
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->load(Yii::$app->request->post());
        $model->setAdressByZipCode(Yii::$app->request->post('User')['zip_code']);

        if(! $model->save() or (empty($model->city))) {
            if(empty($model->city))
                $model->addError('zip_code', 'Enter valid zip code');
            $model->undoConvertedDOB();
            return $this->renderAjax('complete', [
                'model' => $model,
            ]);
        }

        return $this->actionInstagramPhotos($model->id);
    }
    private function getInstagram(){
        $redirectUrl = Yii::$app->params['domen'].'/site/instagram-token';

        return  new Instagram(array(
            'apiKey'      => Yii::$app->params['instagramApiKey'],
            'apiSecret'   => Yii::$app->params['instagramApiSecret'],
            'apiCallback' => $redirectUrl
        ));

    }
    public function actionInstagramToken(){
        $code = $_GET['code'];
        $instagram = $this->getInstagram();
        $data = $instagram->getOAuthToken($code);
        $id = Yii::$app->session['user_id_instagram'];

        $model = User::find()->where(['id' => $id])->one();
        $model->instagram_token = $data->access_token;
        $model->instagram_user_id = $data->user->id;
        $model->scenario = 'instagram';
        if($model->save()){

        }
        echo '<script>window.close();</script>';

    }
    public function actionInstagramPhotos($id){
        $instagram = $this->getInstagram();
        $model = User::find()->where(['id' => $id])->one();
        if(!$model->instagram_token){
            Yii::$app->session['user_id_instagram'] = $model->id;
            return $this->renderAjax('instagram_photos',['model' => $model, 'instagramtUrl' => $instagram->getLoginUrl()]);
        }else{
            $images = $instagram->getUserMedia($model->instagram_user_id, 1000);
            return $this->renderAjax('instagram_photos',['model' => $model, 'images' => $images]);
        }

    }

    public function actionInstagramMorePhotos($url){
        $data = @file_get_contents($url);
        $data = @json_decode($data);

        $jsonResult = [
            'html' => $this->renderPartial('instagram_more_photos', [
                'images' => $data
            ]),
            'next_url' => isset($data->pagination->next_url) ? $data->pagination->next_url: null
        ];

        echo json_encode($jsonResult);
    }
    public function actionSaveInstagramAvatar(){
        $userId = Yii::$app->session['user_id_instagram'];
        if(!empty($_POST) && $userId && $user = User::find()->where(['id' => $userId])->one()){
            $photo = new Photo();
            $user->avatar = $photo->loadInstagramPhoto($_POST['image'], 'image');
            $user->avatar_id = 0;
            $user->scenario = 'avatar';
            if($user->save()){
                return $this->renderAjax('preview', [
                    'model' => $user,
                ]);
            }
            return $this->InstagramPhotos($user);
        }
    }

/*    public function actionEmail($hash)
    {
        $user = User::findByPasswordResetToken($hash);
        if($user instanceof User)
        {
            $user->scenario = 'step2';
            $user->status = User::STATUS_EMAIL_CONFIRM;
            if($user->load(Yii::$app->request->post())){
                $user->loadPhoto('avatar');
                if($user->save()) {
                    $this->redirect(Url::to(['preview', 'id' => $user->id]));
                }
            }

            return $this->render('complete', [
                'model' => $user,
            ]);
        }
        else {
            return $this->render('confirmation', ['type' => 'not_valid_hash']);
        }
    }
*/

    public function actionSetPassword($hash)
    {
        $user = User::findByPasswordResetToken($hash);
        if($user instanceof User)
        {
            $user->scenario = 'reset';
            if($user->load(Yii::$app->request->post())){
                $user->setPassword($user->password);
                if($user->save()) {
                    return $this->render('resetPasswordSuccess', [
                        'model' => $user,
                    ]);
                }
            }

            return $this->render('resetPassword', [
                'model' => $user,
            ]);
        }
        else {
            return $this->render('notFound', ['type' => 'not_valid_hash']);
        }
    }

    public function actionCompleteJoin()
    {
        $model = User::find()->where(['id' => Yii::$app->request->post('User')['id']])->one();
        if(!$model instanceof User)
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->scenario = 'step3';
        $model->status = User::STATUS_ACTIVE;
        $model->save();
        Yii::$app->user->login($model);
        //отправка welcome письма
        NotificationTask::addMail(array(Yii::$app->user->getId()), Config::getValue('mainPage', 'welcome_letter'));
        $this->redirect(Url::to(['/user/profile']));
    }

    public function actionConfirmation()
    {
        return $this->render('confirmation', ['type' => 'ok']);
    }

    public function actionResetPassword($hash = null)
    {

        if(!empty($hash))
        {
            $user = User::findByPasswordResetToken($hash);
            if($user instanceof User)
            {
                if($user->load(Yii::$app->request->post()))
                {
                    $user->setPassword($user->password);
                    if($user->save()){
                    return $this->render('confirmation', ['type' => 'success_change_password']);
                    }
                }
                return $this->render('reset-password-form', ['model' => $user]);
            }
            else {
                return $this->render('confirmation', ['type' => 'not_valid_hash']);
            }
        }
        else if(Yii::$app->request->post('email'))
        {
            $model = User::find()->where(['email' => Yii::$app->request->post('email')])->one();
            if($model instanceof User)
            {
                $model->scenario = 'edit';
                $model->generatePasswordResetToken();
                if($model->save()) {
                    Yii::$app->mail->compose('/mail/resend_password_email', ['model' => $model])
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['serviceName']])
                        ->setTo($model->email)
                        ->setSubject(Config::getValue('mainPage', 'reset_password_subject'))
                        ->send();
                    return $this->renderPartial('confirmation', ['type' => 'reset-password']);
                }
                else
                {
                    foreach($model->getErrors() as $error){
                        echo implode(', ', $error). '<br>';
                    }
                    exit();
                }
            }
            else {
                return '<div class="error"> User not found </div>';
            }
        }

        return $this->renderAjax('/site/_forgotPasswordForm');
    }


    /************   Party    *************/

    public function actionParties()
    {
        //$query = Party::searchNew($_GET)->orderBy('rank')->limit(6);
		$query = Party::searchNew($_GET)->orderBy('rank');
        $query->with([
                'photo' => function ($query) {
                    $query->where('photo.deleted_party =0 or photo.deleted_party is NULL')
                        ->orderBy('photo.view_count DESC');
                },
                'sale' => function ($query) {
                    $query->where(['<=', 'sale.started_at', time()]);
                    $query->andWhere(['>=', 'sale.finished_at', time()]);},
                'party2profile' => function($query)
                {
                    $query->joinWith('user')
                    ->orderBy('user.rank')
                    ->limit(8);
                }]
        );

        $party = $query->all();
        $countAll = $query->count();

       /* return $this->render('parties', [
                'parties' => $party,
                'is_last' => ($countAll <= 6)
            ]);*/
			
			return $this->render('parties', [
                'parties' => $party
            ]);
			
    }

    public function actionLoadMoreParty($pages)
    {
        $party = Party::searchNew($_GET)->limit(4)->offset($pages);
        $party->with([
                'photo' => function ($query) {
                    $query->limit(8);
                },
                'sale' => function ($query) {
                    $query->where(['<=', 'sale.started_at', time()]);
                    $query->andWhere(['>=', 'sale.finished_at', time()]);},
                'party2profile' => function($query)
                {
                    $query->joinWith('user')
                        ->orderBy('user.rank')
                        ->limit(8);
                }]
        );
        $parties = $party->all();
        $countAll = Party::searchNew($_GET)->count();

        $jsonResult = [
            'html' => $this->renderPartial('_party_block', [
                'parties' => $parties
            ]),
            'last' => ($countAll < ($pages + 4))
        ];

        echo json_encode($jsonResult);
    }

    public function actionGetParties($term)
    {
        $partySearch = Party::classicSearch();
        $partySearch->select(['title as value', 'party.url as id']);
        $partySearch->andFilterWhere(['like', 'title', $term]);
        $partySearch = $partySearch->asArray()->all();

        echo json_encode($partySearch);
    }

    public function actionParty($id, $preview=0)
    {
        $party = Party::find()
            ->with(['publicPhoto','contact', 'sale' => function($query)
            {
                $query->with('ticket');
                $query->andWhere(['<=', 'sale.started_at', time()]);
                $query->andWhere(['>=', 'sale.finished_at', time()]);
            },
            'photo' => function($query)
            {
                $query->orderBy('view_count DESC')
                    ->where('deleted_party =0 or deleted_party is NULL')
                    ->limit(5);
            }]);
        if($preview == 0)
            $party->where(['url' => $id, 'party.status' => 1]);
        else
            $party->where(['url' => $id]);

        $party = $party->one();
        if($party instanceof Party)
        {
            $profile = Party2profile::find()
                ->joinWith('user')
                ->where(['party_id' => $party->id])
                ->orderBy('user.rank ASC, user.view_count DESC')
                ->all();

            //$party->photos = Photo::getPartyPhotos($party->id);
            if(time() > strtotime($party->started_at))
            return $this->render('past_party',
                    [
                        'party' => $party,
                        'photo' => new photo(),
                        'profile' => $profile
                    ]);
            else {
                return $this->render('party',
                    [
                        'party' => $party,
                        'photo' => new photo(),
                        'profile' => $profile
                    ]);
            }
        } else {
        throw new NotFoundHttpException('Party not found');
        }
    }

    public function actionLoadPartyProfile($id, $pages)
    {
        $profile = Party2profile::find()
            ->joinWith('user')
            ->where(['party_id' => $id])
            ->orderBy('user.rank DESC, view_count DESC ')
            ->offset($pages)
            ->limit(12)
            ->all();

        $countAll = Party2profile::find()
            ->joinWith('user')
            ->where(['party_id' => $id])
            ->count();
        $jsonResult = [
            'html' => $this->renderPartial('_party2profile', ['profile' => $profile ]),
            'last' => ($countAll < ($pages + 12))
        ];
        echo json_encode($jsonResult);
    }

    public function actionLoadPartyPhoto($id, $pages)
    {
        $photo = Photo::find()
            ->where(['party_id' =>$id])
            ->orderBy('view_count DESC')
            ->offset($pages)
            ->limit(12)
            ->all();
        $countAll =Photo::find()->where(['party_id' =>$id])->count();
        $jsonResult = [
            'html' => $this->renderPartial('_party2photo', ['photos' => $photo ]),
            'last' => ($countAll < ($pages + 12))
        ];
        echo json_encode($jsonResult);
    }

    /******************  Buy Ticket  ****************/
    public function actionBuyTicket($partyID = null)
    {
        $tickets = Yii::$app->request->get('ticket');
        if(array_sum($tickets) < 1){
            $party = Party::find()->where(['id' => $partyID])->one();
            $this->redirect('/party/'.$party->url);
        }

        if($tickets)
        {
            $models = [];
            foreach($tickets as $ticket => $quantity) {
                $ticket = TicketType::find()
                    ->where(['id' => $ticket])
                    ->with('sale.party')
                    ->one();
                $n = $ticket->countAvailable();
                $total = ($quantity > $n)? $quantity :  $quantity;
                $number = 1;
                while($total--){
                    $model = new Form();
                    $model->ticket_id = $ticket->id;
                    $model->data['ticket_title'] = $ticket->title. ' #'. ($number++);
                    $model->data['ticket'] = $ticket->toArray();
                    $model->data['sale'] = $ticket->sale->toArray();
                    $model->data['party'] = $ticket->sale->party->toArray();
                    $models[] =$model;
                }
            }

            if(!empty($_POST)){
                $valid = true;
                foreach($models as $key => $model){
                    $model->load(array('Form' => $_POST['Form'][$key]));
                    if(!$model->validate()){
                        $valid = false;
                    }
                }

                if($valid){
                    $total = array('price' => 0, 'count' => 0 , 'tickets' => [], 'description' => '');
                    foreach($models as &$model){
                        $model = $model->toArray();
                        $total['price'] += $model['data']['ticket']['price'];
                        $total['count'] += 1;
                        $total['description'][] = $model['data']['ticket']['description'] . '@'.$model['data']['ticket']['price'];
                        @$total['tickets'][$model['ticket_id']] += 1;
                    }
                    Yii::$app->session->set('tickets', $models);
                    Yii::$app->session->set('ticket_summary', $total);
                    return  $this->redirect('/site/pay-tickets');
                }
            }
            elseif($user = User::find()->where(['id' =>Yii::$app->user->getId()])->one()){
                $models[0]->email = $user->email;
                $models[0]->name = $user->name;
                $models[0]->lastname = $user->last_name;
            }

            return $this->render('buyTicket', [
                'models' => $models
            ]);
        }
        else {
            $this->redirect('/');
        }
    }
    public function actionPayTickets()
    {
        $summary = Yii::$app->session->get('ticket_summary');
        if(empty($summary)){
            $this->redirect('/site/buy-ticket');
        }
        return $this->buyTickets($summary['price'], implode('#', $summary['description']), Yii::$app->session->get('tickets'));
    }
    private function buyTickets($amount, $description = '', $tickets)
    {
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
            $sale->email = $data['email'];
            $sale->description = $description;
            foreach($tickets as $key => $ticket){
                $ticket = $ticket['data']['ticket'];
                $sale->addLineItem('#'.($key+1), $ticket['title'], $ticket['description'], 1, $ticket['price'], 0);
            }

            $response = $sale->authorizeAndCapture();
            if ($response->approved) {
                $this->emailTicket($response->transaction_id);
                $this->redirect('/site/complete-ticket');
            }
            $errorMessage =  isset($response->response_reason_text)? $response->response_reason_text : @$response->error_message;
        }

        return $this->render('buyTickets', [
            'user' => $user,
            'amount' => $amount,
            'description' => $description,
            'tickets' => $tickets,
            'errorMessage' => $errorMessage,
        ]);
    }
    public function actionCompleteTicket(){

        $tickets = Yii::$app->session->get('tickets');
        if($data = Yii::$app->request->post()){
            $data['ticket'] = isset($data['ticket']) ? $data['ticket'] : array();
            foreach($data['ticket'] as $id => $userId){
                $ticket = Ticket::find()->where(['id' => $id])->one();
                $ticket->user_id = $userId;
                $ticket->save();
                if(!Party2profile::is_shared($ticket->party_id, $userId)){
                    Party2profile::share($ticket->party_id, $userId);
                }
                NotificationTask::addTicket($userId, 'Bought a ticket for '.$tickets[0]['party']['title']);
            }
            $this->redirect('/user/dashboard');
        }
        $ticketUsers = Yii::$app->session->get('users');
        if(empty($ticketUsers)){
            $this->redirect('/site/pay-tickets');
        }
        $userId = Yii::$app->user->getId();
        $userId = empty($userId) ? -1 : $userId;
        foreach($tickets  as &$ticket){
            $name = strtolower($ticket['name']);
            $lastname = strtolower($ticket['lastname']);
            $ticket['users'] = User::find()
                ->where(['email' => $ticket['email'], 'status' =>10])
                ->orWhere("LOWER(name) = '$name' and LOWER(last_name) = '$lastname' and status=10")
                ->orWhere(['id' => $userId])
                ->all();
        }
        return $this->render('buyTicketComplete', [
            'tickets' => $tickets,
            'emails' => array_unique($ticketUsers['emails']),
        ]);
    }
    private function emailTicket($transaction_id = null){
        $users = array('emails'=>[], 'names'=>[], 'last_names'=>[]);
        $tickets = [];
        $paidBy = Yii::$app->user->getId();
        foreach(Yii::$app->session->get('tickets') as $key => $ticket){
            $users['emails'][] = $ticket['email'];
            $users['name'][] = $ticket['name'];
            $users['last_names'][] = $ticket['lastname'];
            $ticketCount = Ticket::find(['party_id' => $ticket['data']['party']['id']])->count();
            $ticketNumber = $ticket['data']['party']['ticket_prefix']. ($ticketCount+1);
            $ticketModel = new Ticket(
                [
                    'party_id' => $ticket['data']['party']['id'],
                    'user_id' => 0,
                    'paid_by' => $paidBy,
                    'name' => $ticket['name'],
                    'lastname' => $ticket['lastname'],
                    'email' => $ticket['email'],
                    'instagram' => $ticket['instagram'],
                    'transaction_id' => $transaction_id,
                    'bought_at' => time(),
                    'ticket_number' => $ticketNumber,
                    'ticket_number_seq' => $ticketCount+1,
                    'hash' => Ticket::generateHash($ticket['data']['ticket']['id'].'#'. $ticket['email'], $ticket['data']['ticket']['price']),
                    'ticket_type_id' => $ticket['data']['ticket']['id']
                ]
            );

            $ticketModel->save();

            Yii::$app->mail->compose('/mail/email_ticket', ['ticket' => $ticketModel, 'party' => $ticket['data']['party']])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['serviceName']])
                ->setTo($ticket['email'])
                ->setSubject('Bought ticket')
                ->send();


            $tickets[$key] =$ticketModel->toArray();
            $tickets[$key]['title'] = $ticket['data']['ticket_title'];
            $tickets[$key]['price'] = $ticket['data']['ticket']['price'];
            $tickets[$key]['party'] = $ticket['data']['party'];
        }
        Yii::$app->session->remove('tickets');
        Yii::$app->session->remove('ticket_summary');
        Yii::$app->session->set('users', $users);
        Yii::$app->session->set('tickets', $tickets);
    }
    public function actionBuyTicket_($partyID)
    {
        if(Yii::$app->request->get('ticket'))
        {
            $order = [];
            $totalPrice = 0;
            $invoice = [];
            foreach(Yii::$app->request->get('ticket') as $ticket => $kol) {
                //проверить что эти билеты еще есть
                $ticket = TicketType::find()
                    ->where(['id' => $ticket])
                    ->with('sale.party')
                    ->one();
                if ($ticket instanceof TicketType) {

                    $n = $ticket->countAvailable();
                    if ($kol > $n) {
                        $order[$ticket->id]['type_id'] = $ticket->id;
                        $order[$ticket->id]['type'] = $ticket->title;
                        $order[$ticket->id]['kol'] = $n;
                        $order[$ticket->id]['price'] = $ticket->price;
                        $totalPrice += $n * $ticket->price;
                        $invoice[] = $ticket->id.'#'.$n;
                    } else {
                        $order[$ticket->id]['type_id'] = $ticket->id;
                        $order[$ticket->id]['type'] = $ticket->title;
                        $order[$ticket->id]['kol'] = $kol;
                        $order[$ticket->id]['price'] = $ticket->price;
                        $totalPrice += $kol * $ticket->price;
                        $invoice[] = $ticket->id.'#'.$kol;
                    }
                }
            }

            $fp_sequence = rand(0, 100).substr(time(), -6);
            $amount = $totalPrice;

            $time = time();
            $fp = \AuthorizeNetDPM::getFingerprint(AUTHORIZENET_API_LOGIN_ID, AUTHORIZENET_TRANSACTION_KEY, $amount, $fp_sequence, $time);
            $sim = new \AuthorizeNetSIM_Form(
                array(
                    'x_amount'        => $amount,
                    'x_fp_sequence'   => $fp_sequence,
                    'x_fp_hash'       => $fp,
                    'x_fp_timestamp'  => $time,
                    'x_relay_response'=> "TRUE",
                    'x_relay_url'     => "http://941social.com/site/response",
                    'x_login'         => AUTHORIZENET_API_LOGIN_ID,
                    'x_description'   => implode('@', $invoice),
                    'party_id'        => $partyID,
                )
            );
            $hidden_fields = $sim->getHiddenFieldString();
            $post_url = \AuthorizeNetDPM::SANDBOX_URL ; // : self::LIVE_URL);
            return $this->render('paymentPage', [
                'order' => $order,
                'post_url' => $post_url,
                'hidden_fields' => $hidden_fields,
                'partyID' => $partyID
            ]);
        }
        else {
            throw new NotFoundHttpException('not selected tickets');
        }
    }

    public function actionResponse()
    {
        $response = new \AuthorizeNetSIM(AUTHORIZENET_API_LOGIN_ID, "");
        if ($response->isAuthorizeNet() && ($response->transaction_id !=0)) {

            $res = $response->response;
            $ticketTypes = explode('@', $res['description']);
            $orderTickets = [];
            $currentUser = (Yii::$app->user->getId()) ? Yii::$app->user->getId() : 0;
            foreach($ticketTypes as $type)
            {
                $tmp = explode('#', $type);
                if(isset($tmp[0]) && isset($tmp[1]))
                {
                    for($i=1; $i<=$tmp[1]; $i++)
                    {
                        $ticket = new Ticket(
                            [
                                'party_id' => $res['party_id'],
                                'user_id' => $currentUser,
                                'bought_at' => time(),
                                'hash' => Ticket::generateHash($tmp[0].'#'. $res['party_id'], $currentUser),
                                'ticket_type_id' => $tmp[0]
                            ]
                        );
                        if($ticket->save())
                        {
                            $orderTickets[] = $ticket;
                        }
                    }
                }
            }

            Yii::$app->mail->compose('/mail/ticket_email', ['tickets' => $orderTickets])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['serviceName']])
                ->setTo($response->email_address)
                ->setSubject('Bought ticket')
                ->send();

            echo \AuthorizeNetDPM::getRelayResponseSnippet(Yii::$app->params['domen'].'/site/thank-you/'.$response->transaction_id);
        }
        else {
            echo \AuthorizeNetDPM::getRelayResponseSnippet(Yii::$app->params['domen'].'/site/thank-you/'.$response->response_reason_text);
        }
    }

    public function actionThankYou($id)
    {
        if(is_numeric($id))
            return $this->render('tank-you-page', ['id' => $id]);
        else return $this->render('error-page', ['id' => $id]);
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

    public function actionUploadToParty($id){
        $party = party::findOne(['id' => $id]);
        $photo = new photo();
        if($photo->load(Yii::$app->request->post())){
            $photo->party_id = $id;
            $photo->load_user_id = Yii::$app->user->getId();
            $photo->created_at = time();
            $photo->loadImage('image');
            if($photo->save()){
                if(!$party2Profile = Party2profile::findOne(['user_id' => Yii::$app->user->getId(), 'party_id' => $id])){
                    $party2Profile = new Party2profile();
                    $party2Profile->user_id =  Yii::$app->user->getId();
                    $party2Profile->party_id =  $id;
                    $party2Profile->created_at =  time();
                    $party2Profile->save();
                }
                NotificationTask::addPhoto(Yii::$app->user->getId());
                $photo = Photo::find()
                    ->where(['id' => $photo->id])
                    ->with('user', 'share', 'party')
                    ->one();

                return $this->renderAjax('_photo', [
                    'photo' => $photo,
                    'new' => 1,
                    'likes' => Likes::getLikes($photo->id),
                    'userId' => Yii::$app->user->getId(),
                    'user' => User::findOne(Yii::$app->user->getId()),
                    'shares' => SharingPhoto::getShares($photo->id)
                ]);
            }
        }
        return $this->renderAjax('party-image-upload', ['party' => $party, 'photo'=> new photo()]);
    }

    public function actionInstagram()
    {
        header('Content-type: text/html; charset=utf-8');
        error_reporting(-1);
        ini_set('display_errors', 1);

        $instagram = new Instagram(array(
            'apiKey'      => '96edaf43296b4bf2ac7a6db17d79bdb5',
            'apiSecret'   => '59e3b6c20b754a5ca1f73ee144332bc1',
            'apiCallback' => 'http://941social.com/site/instagram' // must point to success.php
        ));

        // create login URL
        $loginUrl = $instagram->getLoginUrl();
        $code = !empty($_GET['code']) ? $_GET['code'] : null;

        if ($code) {
            // receive OAuth token object
            $oauthToken = $instagram->getOAuthToken($code);

            // invalid oauthtoken
            if (empty($oauthToken->access_token)) {
                var_dump($oauthToken);
                die();
            }

            // set access token (store it somewhere if you need)
            $instagram->setAccessToken($oauthToken->access_token);

            // now you have access to all authenticated user methods
            $userMedia = $instagram->getUserMedia();

            $photos = $userMedia->data;

            foreach($photos as $photo): ?>
                <?php $image = $photo->images->low_resolution; ?>
                <div style="display: inline-block; margin: 15px;">
                    <a href="<?php echo $photo->link; ?>">
                        <img src="<?php echo $image->url; ?>" width="<?php echo $image->width; ?>" height="<?php echo $image->height; ?>" alt=""/>
                    </a>
                    <div style="margin-top: 10px"><?php echo $photo->caption->text; ?></div>
                </div>
            <?php endforeach;
        } else {
            // check whether an error occurred
            if (isset($_GET['error'])) {
                echo 'An error occurred: ' . $_GET['error_description'];
            }

            echo "<a href='$loginUrl'>Login with Instagram</a>";
        }
    }
    public function actionSaveComment(){
        $data = Yii::$app->request->post();
        $class = sprintf('app\models\%s', $data['model']);
        if(!empty($data['id']) ){
            $model = $this->findModel($data['id'], sprintf('app\models\%s', $data['model']));
            $model->$data['name'] = $data['val'];
            $model->Save();
        }
        elseif('SharingPhoto' == $data['model']){
            if($data['party_id']){
                Party2profile::share($data['party_id'], Yii::$app->user->getId());
            }
            $model = new $class;
            $model->$data['name'] = $data['val'];
            $model->obj_id = $data['obj_id'];
            $model->type = 0;
            $model->user_id =Yii::$app->user->getId();
            $model->created_at =time();
            NotificationTask::addPhoto(Yii::$app->user->getId());
            $model->Save();
        }


        $photo = Photo::find()
            ->where(['id' => $data['obj_id']])
            ->with('user', 'share', 'party')
            ->one();
        return $this->renderAjax('_photo', [
            'photo' => $photo,
            'likes' => Likes::getLikes($photo->id),
            'userId' => Yii::$app->user->getId(),
            'user' => $user = User::findOne(Yii::$app->user->getId()),
            'shares' => SharingPhoto::getShares($photo->id)
        ]);
    }
    public function actionDeletePhoto($id = 0)
    {
        $userId = Yii::$app->user->getId();

        $photo = Photo::find()->where(['id' => $id, 'load_user_id' => $userId])->one();
        if($photo->load_user_id === Yii::$app->user->getId()){
            $photo->deleted_user = 1;
            if(@$_POST['new'] == 1 ){
                $photo->deleted_party = 1;
            }
            $photo->save();
        }else{
            $photo = SharingPhoto::find()->where(['obj_id' => $id, 'type' => 0, 'user_id' => $userId])->one();
            $photo->delete();
        }

        $partyPhoto = Photo::find()
            ->where(['party_id' => $photo->party_id, 'load_user_id' => $userId])
            ->andWhere('(deleted_party =0 or deleted_party is NULL)')
            ->one();
        if(!$partyPhoto){
            if($party2profile = Party2profile::find()->where(['party_id' => $photo->party_id, 'user_id' => $userId])->one())
            {
                $party2profile->delete();
            }
        }

        echo 'done';
    }
    public function actionUndeletePhoto($id = 0){

        $photo = Photo::find()->where(['id' => $id])->one();
        $photo->deleted_user = 0;
        $photo->save();
        echo 'done';
    }
    public function actionTicket($hash = '-1'){
        $ticket = Ticket::find()
            ->with('party', 'user', 'detail')
            ->where(['hash' => $hash])->one();

        return  $this->render('my_tickets', [
            'ticket' => $ticket,
        ]);
    }
    public function actionPrintTicket($hash = '-1'){

        $ticket = Ticket::find()
            ->with('party', 'user', 'detail')
            ->where(['hash' => $hash])->one();

        echo  $this->renderPartial('print_tickets', [
            'ticket' => $ticket,
        ]);
    }
    public function actionPizzaCat(){
        echo  $this->renderPartial('pizza-cat');
    }
}


