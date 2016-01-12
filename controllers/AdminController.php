<?php

namespace app\controllers;

use app\models\AuthAssignment;
use app\models\Message;
use app\models\NotificationTask;
use app\models\Page;
use app\models\Party2profile;
use app\models\PartyContact;
use app\models\Photo;
use app\models\Sale;
use app\models\Staff2party;
use app\models\Ticket;
use app\models\TicketType;
use app\models\User2group;
use app\models\UserGroup;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;


use app\models\Party;
use app\models\User;
use app\models\LoginForm;
use app\models\Config;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public $layout = 'admin';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'add-party', 'update-party'],
                        'allow' => true,
                        'roles' => ['staff-level2', 'staff-level3'],
                    ],
                    [
                        'actions' => ['publish-party', 'unpublish-party', 'delete-party', 'user', 'update-user'],
                        'allow' => true,
                        'roles' => ['staff-level2'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['staff-level1']
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if(Yii::$app->user->isGuest)
            $this->redirect(Url::to('/admin/login'));
        return $this->render('index');
    }

    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest)
            $this->redirect(Url::to('/admin/index'));

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Url::to('/admin/index'));
        } else {
            return $this->renderPartial('login', ['model' => $model]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /******************  Party  ****************/

    public function actionParty()
    {

        $party = new Party();
        return $this->render('party', [
            'dataProvider' => $party->getDataProvider()
        ]);
    }

    public function actionAddParty()
    {
        $party = new Party();
        $party->created_at = time();
        $party->allow2sharing = true;
        $party->allow2add_photo = true;
        if ($party->load(Yii::$app->request->post()) && $party->save()) {
            return $this->redirect(Url::toRoute(['update-party', 'id' => $party->id]));
        }

        return $this->render('createParty', ['model' => $party]);
    }

    public function actionUpdateParty($id, $tab=1)
    {

        //MAIN INFO
        $party = $this->findModel($id, 'app\models\Party');
        $partyContact = PartyContact::find()->where(['party_id' => $id])->all();
        $members = Party2profile::find()
                    ->with('user')
                    ->where(['party_id' => $id])
                    ->all();
        $staff = Staff2party::find()
            ->with('user')
            ->where(['party_id' => $id])
            ->all();

        if($party->load(Yii::$app->request->post())){
            //echo'<pre>'; print_r(Yii::$app->request->post());die;
            $party->loadPhoto('thumbnail');
            $party->loadPhoto('mini_flyer');
            $party->loadPhoto('flyer_top');
            $party->loadPhoto('flyer_bottom');
            $party->loadPhoto('message_banner');
	    $party->loadPhoto('party_first');
	    $party->loadPhoto('party_last');
	    $party->loadPhoto('party_more');
            if($party->save()){
                return $this->refresh();
            }

        }

        // FLASH SALE
        $flashSale = Sale::find()
        ->where(['party_id' => $id, 'sale_type' => 0])
        ->with('ticket')
        ->one();

        if(!$flashSale instanceof Sale)
        {
            $flashSale = new Sale();
            $flashSale->sale_type = 0;
            $flashSale->party_id = $id;
            $flashSale->created_at = time();
        }

        if($tab == 2)
        {
            if($flashSale->load(Yii::$app->request->post()))
            {
                $flashSale->loadPhoto('thumbnail');
                $flashSale->loadPhoto('mini_flyer');
                $flashSale->loadPhoto('flyer_top');
                $flashSale->loadPhoto('flyer_bottom');
                $flashSale->loadPhoto('message_banner');
		$flashSale->loadPhoto('party_first');
                $flashSale->loadPhoto('party_last');
                $flashSale->loadPhoto('party_more');
                if($flashSale->save()) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('yii','Save'));
                    $this->refresh();
                }
            }
        }

        //REGULAR SALE
        $regSale = Sale::find()
            ->where(['party_id' => $id, 'sale_type' => 1])
            ->with('ticket')
            ->one();

        if(!$regSale instanceof Sale)
        {
            $regSale = new Sale();
            $regSale->sale_type = 1;
            $regSale->party_id = $id;
            $regSale->created_at = time();
        }

        if($tab == 3)
        {
            if($regSale->load(Yii::$app->request->post()))
            {
                $regSale->loadPhoto('thumbnail');
                $regSale->loadPhoto('mini_flyer');
                $regSale->loadPhoto('flyer_top');
                $regSale->loadPhoto('flyer_bottom');
                $regSale->loadPhoto('message_banner');
		$regSale->loadPhoto('party_first');
                $regSale->loadPhoto('party_last');
                $regSale->loadPhoto('party_more');
                if($regSale->save()) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('yii','Save'));
                    $this->refresh();
                }
            }
        }

        return $this->render('updateParty', [
            'model' => $party,
            'contact' => $partyContact,
            'members' => $members,
            'staff' => $staff,
            'tab' => $tab,
            'regSale' => $regSale,
            'flashSale' => $flashSale
        ]);
    }

    public function actionDeleteParty($id)
    {
        return $this->deleteAndRedirect($id, 'app\models\Party', ['party']);
    }

    public function actionPublishParty($id)
    {
        $party = $this->findModel($id, 'app\models\Party');
        //нельзя запаблишить пати пока нет сейла, если пати будущая, тк картинки берутся с сейла!
        if(strtotime($party->started_at) > time())
        {
            if(Sale::find()->where(['party_id' => $id])
                ->andWhere(['<=', 'started_at', time()])
                ->andWhere(['>=', 'sale.finished_at', time()])->exists())
            {
                $party->status = 1;
                $party->save();
                $this->redirect(Url::to(['update-party', 'id' => $party->id]));
            }
            else {
                Yii::$app->getSession()->setFlash('success', Yii::t('yii','Party must not be published until no active sale!'));
                $this->redirect(Url::to(['update-party', 'id' => $party->id]));
            }
        }
        else {
            $party->status = 1;
            $party->save();
            $this->redirect(Url::to(['update-party', 'id' => $party->id]));
        }
    }

    public function actionUnpublishParty($id)
    {
        $party = $this->findModel($id, 'app\models\Party');
        $party->status = 0;
        $party->save();
        $this->redirect(Url::to(['update-party', 'id' => $party->id]));
    }

    public function actionAttachStaff($partyID, $userID=null)
    {
        if(!empty($userID))
        {
            if(!Staff2party::find()
                ->where(['user_id' => $userID, 'party_id' => $partyID])
                ->exists())
            {
                $model = new Staff2party();
                $model->party_id = $partyID;
                $model->user_id = $userID;
                if ($model->save()) {
                    $staff2Party = Staff2party::find()->where(['party_id' => $partyID])->all();
                    return $this->renderPartial('_staff2party', ['staff' => $staff2Party]);
                }
            }

            $staff2Party = Staff2party::find()->where(['party_id' => $partyID])->all();
            return $this->renderPartial('_staff2party', ['staff' => $staff2Party]);
        }

        $staff = AuthAssignment::find()
            ->with('user')
            ->where('item_name in ('.Yii::$app->params['staffRoles'].')')
            ->all();

        return $this->renderAjax('findStaff', [
                'staff' => $staff,
                'partyID' => $partyID
        ]);
    }

    /******************  Party Photo  ***************/

    public function actionPartyPhoto($id)
    {
        $photos = Photo::find()
            ->with('user')
            ->where(['party_id' => $id])
            ->orderBy('status, created_at')
            ->all();
        return $this->render('party-photo', [
                'id' => $id,
                'photos' => $photos
        ]);
    }

    public function actionUpload($partyID)
    {
        $photo = New Photo();
        $photo->load_user_id = Yii::$app->user->getId();
        $photo->status = 1;
        $photo->party_id = $partyID;
        $photo->created_at = time();
        $photo->image = $photo->loadPhoto('photo');
        if($photo->save())
        {
            $filejson = new \stdClass();
            $filejson->files[] = [
//                'url' =>  Yii::$app->params['imagePath'].$photo->image,
//                'thumbnail_url' =>  Yii::$app->params['imagePath'].$photo->image,
                'name' =>  "Success",
            ];
            echo json_encode($filejson);
        }
        else print_r($photo->getErrors());
    }

    public function actionDeletePhoto($id)
    {
        Photo::findOne($id)->delete();
    }

    public function actionApprove($id)
    {
        $photo = $this->findModel($id, 'app\models\Photo');
        $photo->status = 1;
        $photo->save();
        $this->redirect(Url::to(['/admin/party-photo', 'id' => $photo->party_id]));
    }

    /******************  Party Sale & Ticket  ***************/

    public function actionEditPrice($id)
    {
        $party = $this->findModel($id, 'app\models\Party');
        $sale = Sale::find()
            ->where(['party_id' => $id])
            ->with('ticket')
            ->all();
        return $this->render('edit-price', [
            'party' => $party,
            'sale'  => $sale
        ]);
    }

    public function actionAddSale($id)
    {
        $sale = new Sale();
        $sale->party_id = $id;
        $sale->created_at = time();

        $sale->loadPhoto('mini_flyer');
        $sale->loadPhoto('flyer_top');
        $sale->loadPhoto('flyer_bottom');
        $sale->loadPhoto('message_banner');
	$sale->loadPhoto('party_first');
        $sale->loadPhoto('party_last');
        $sale->loadPhoto('party_more');
        
	if($sale->load(Yii::$app->request->post()) && $sale->save())
        {
            $this->redirect(Url::to(['edit-price', 'id' => $id]));
        }

        return $this->render('add-sale', [
                'model' => $sale
            ]);
    }

    public function actionAddTicket($id, $saleID, $tab)
    {
        $ticket = new TicketType();
        $ticket->sale_id = $saleID;
        $ticket->created_at = time();
        if($ticket->load(Yii::$app->request->post()))
        {
            $ticket->loadPhoto('image');
            if($ticket->save())
            {

                $this->redirect(Url::to(['/admin/update-party/', 'id' => $id, 'tab' => $tab]));
            }
            else {
                return $this->render('add-ticket', [
                    'model' => $ticket,
                    'party_id'=> $id,
                    'tab' => $tab
                ]);
            }
        }

        return $this->renderAjax('add-ticket', [
            'model' => $ticket,
            'party_id'=> $id,
            'tab' => $tab
        ]);
    }

    public function actionDeleteTicketType($id, $partyID, $tab)
    {
        $ticket = TicketType::findOne($id);
        $ticket->delete();
        $this->redirect(Url::to(['/admin/update-party', 'id' => $partyID, 'tab' => $tab]));
    }

    public function actionDeleteSale($id)
    {
        $sale = $this->findModel($id, 'app\models\Sale');
        $sale->delete();
    }

    /******************  Contact  ****************/
    public function actionUpdateContact($id)
    {
        $model = $this->findModel($id, 'app\models\PartyContact');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $partyContact = PartyContact::find()->where(['party_id' => $model->party_id])->all();

            return $this->renderPartial('_contact', ['contact' => $partyContact, 'id' => $model->party_id]);
        }

        return $this->renderAjax('update-contact', [
            'model' => $model,
        ]);
    }

    public function actionAddContact($partyID)
    {
        $model = new PartyContact();
        $model->party_id = $partyID;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $partyContact = PartyContact::find()->where(['party_id' => $model->party_id])->all();

            return $this->renderPartial('_contact', ['contact' => $partyContact, 'id' => $model->party_id]);
        }

        return $this->renderAjax('update-contact', [
            'model' => $model,
        ]);
    }

    public function actionDeleteContact($id, $partyID)
    {
        return $this->findModel($id, 'app\models\PartyContact')->delete();
    }

    /*****************    User   *********************/

    public function actionUser()
    {
        $model = new User();
        $model->scenario = 'find';

        return $this->render('user', [
                'dataProvider' => $model->searchDataProvider(Yii::$app->request->queryParams),
                'searchModel' => $model
            ]);
    }

    public function actionUpdateUser($id)
    {
        $model = $this->findModel($id, 'app\models\User');
        $model->scenario = 'edit';

        if($model->load(Yii::$app->request->post()) && $model->save()){
            if(Yii::$app->user->can('resetPermission')){
                Yii::$app->authManager->revokeAll($model->getId());
            }
            else if(Yii::$app->user->can('setRole_staff-level3')){
                $role = Yii::$app->authManager->getRole("staff-level3");
                Yii::$app->authManager->revoke($role, $model->getId());
            }

            $userRoles = Yii::$app->authManager->getRolesByUser($model->getId());

            foreach(Yii::$app->request->post('roles', array()) as $role)
            {
                if( Yii::$app->user->can('setRole_'.$role)
                    && (!isset($userRoles[$role]))
                ){
                    $new_role = Yii::$app->authManager->getRole($role);
                    Yii::$app->authManager->assign($new_role, $model->getId());
                }
            }
            Yii::$app->session->setFlash('success', 'Saved');
            $this->refresh();
        }

        $roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
        $user_permit = array_keys(Yii::$app->authManager->getRolesByUser($model->getID()));

        return $this->render('updateUser', ['model' => $model, 'roles' => $roles, 'user_permit' => $user_permit]);
    }

    public function actionResetPassword($id)
    {
        $model = $this->findModel($id, 'app\models\User');
        $model->scenario = 'reset';
        if($model->load(Yii::$app->request->post()))
        {
            $model->setPassword($model->password);
            if($model->save()){
            Yii::$app->session->setFlash('success', 'Saved');
            $this->refresh();
            }
        }

        return $this->render('resetPassword', ['model' => $model]);
    }

    public function actionViewUser($id)
    {
        $model = $this->findModel($id, 'app\models\User');
        $model->scenario = 'edit';

        return $this->render('viewUser', ['model' => $model]);
    }

    public function actionDeleteUser($id)
    {
        $this->deleteAndRedirect($id, 'app\models\User', ['user']);
    }

    public function actionAttachUser($partyID=null)
    {
        if(empty($partyID)) $partyID = Yii::$app->request->get('partyID');
        $searchModel = new User();
        $searchModel->scenario = 'find';
        $searchModel->load(Yii::$app->request->get());
        $query = $searchModel->search(Yii::$app->request->get());
        $result = $query->andWhere(['status' => User::STATUS_ACTIVE])->limit(18)->all();

        return $this->renderAjax('_searchUser',
            [
                'model' => $searchModel,
                'partyID' => $partyID,
                'members' => $result
            ]
        );
    }

    public function actionAttach($id, $partyID)
    {
        if(! Party2profile::find()->where(['user_id' => $id, 'party_id'=> $partyID])->exists())
        {
            $u2p = new Party2profile();
            $u2p->user_id = $id;
            $u2p->party_id = $partyID;
            $u2p->created_at = time();
            $u2p->save();
        }
        $members = Party2profile::find()->where(['party_id'=> $partyID])->all();
        return $this->renderPartial('_members2party', ['members' => $members]);
    }

    public function actionDeleteAttach($id)
    {
        return Party2profile::findOne($id)->delete();
    }

    /******************  Content Page  ****************/
    public function actionPages()
    {

        $page = new Page();
        return $this->render('pages', [
                'dataProvider' => $page->getDataProvider()
            ]);
    }
    public function actionAddPage()
    {
        $page = new Page();
        if($page->updateItem())
            return $this->redirect(Url::toRoute(['pages']));
        return $this->render('createPage', ['model' => $page]);
    }

    public function actionUpdatePage($id)
    {
        $page = $this->findModel($id, 'app\models\Page');
        if($page->updateItem())
            return $this->refresh();
        return $this->render('updatePage', ['model' => $page]);
    }

    public function actionDeletePage($id)
    {
        return $this->deleteAndRedirect($id, 'app\models\Page', ['pages']);
    }

    /******************      Email    ****************/

    public function actionEmail()
    {
        $notification = new NotificationTask(
            [
                'type' => NotificationTask::TYPE_MAIL,
                'from_user' => 0, //0 - admin 941
            ]
        );

        if(Yii::$app->request->post('forGroup') >=-1)
        {
            $notification->value = Yii::$app->request->post('text');
            $notification->dop_value = Yii::$app->request->post('title');

            if(Yii::$app->request->post('forGroup') == -1) {
                $notification->user_list = 'all';
            }
            else {
                $notification->user_list = implode('#', User2group::findAllFromGroup(Yii::$app->request->post('forGroup')));
            }

            if($notification->save())
            {
                $notification->createNotification(User2group::findAllFromGroup(Yii::$app->request->post('forGroup')));
                Yii::$app->getSession()->setFlash('success', Yii::t('yii','Message send success'));
                return $this->refresh();
            }
        }

        if(Yii::$app->request->post('re_id'))
        {
            $message = new Message([
                    're_id' => Yii::$app->request->post('re_id'),
                    'user_from' => 0,
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

        $inboxMessage = Message::find()
            ->with('sender')
            ->where(['user_to' => 0])
            ->orderBy('created_at desc')
            ->all();

        return $this->render('email', [
            'groupList' => UserGroup::search(),
            'model' => $notification,
            'inbox' => $inboxMessage
        ]);
    }

    public function actionAddGroup()
    {
        $model = new UserGroup();
        $model->created_at = time();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $searchModel = new User();
            $searchModel->scenario = 'find';
            $searchModel->load(Yii::$app->request->post());
            $query = $searchModel->search(Yii::$app->request->post());
            $members = $query->andWhere(['status' => User::STATUS_ACTIVE])->limit(18)->all();

            return $this->renderPartial('email_user2group', [
                    'group' => $model,
                    'model' => $searchModel,
                    'members' => $members
                ]);
        }

        return $this->renderPartial('email_add_group', [
                'model' => $model
        ]);
    }

    public function actionFindUser($id)
    {
        $model = UserGroup::findOne($id);

        $searchModel = new User();
        $searchModel->scenario = 'find';
        $searchModel->load(Yii::$app->request->post());
        $query = $searchModel->search(Yii::$app->request->post());
        $members = $query->andWhere(['status' => User::STATUS_ACTIVE])->limit(18)->all();

        return $this->renderPartial('email_user2group', [
                'group' => $model,
                'model' => $searchModel,
                'members' => $members
            ]);
    }

    public function actionAddUserToGroup()
    {
        $i = 0;
        foreach(Yii::$app->request->post('User') as $user)
        {
            if(User2group::add($user, Yii::$app->request->post('groupID')))
                $i++;
        }
        echo $i.' members added to the group';
    }

    public function actionDeleteGroup($id)
    {
        UserGroup::findOne($id)->delete();
        User2group::deleteAll(['group_id' => $id]);
        return $this->redirect(Url::to(['admin/email']));
    }

    public function actionDeleteFromGroup($id)
    {
        User2group::findOne($id)->delete();
        return true;
    }

    public function actionUserInGroup($id)
    {
        $users = User2group::find()->with('users')->where(['group_id' => $id])->all();
        return $this->renderAjax('email_user_in_group', [
                'users' => $users
        ]);
    }

    /******************  Orders  ****************/

    public function actionOrders()
    {
        $model = new Ticket();
        $model->load(Yii::$app->request->queryParams);

        return $this->render('orders', [
            'dataProvider' => Ticket::search($model),
            'searchModel' => $model
        ]);
    }

    public function actionCancelTicket($id)
    {
        $ticket = $this->findModel($id,'app\models\Ticket');

        //Add cancel notification

        //Remove from party2profile

        $ticket->status = Ticket::STATUS_CANCEL;
        if($ticket->save())
            return $this->redirect(Url::to(['/admin/orders']));
    }

    public function actionCheckTicket($hash)
    {
        $ticket = Ticket::find()->where(['hash' => $hash])->with('user', 'party')->one();
        if($ticket instanceof Ticket)
        {
            if($ticket->status == Ticket::STATUS_CANCEL)
            {
                throw new NotFoundHttpException('Ticket canceled!');
            }
            else {
                return $this->renderAjax('checkTicket', ['ticket' => $ticket]);
            }
        }
        else {
            throw new NotFoundHttpException('Ticket not found!');
        }
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

    public function actionConfig()
    {
        if(Yii::$app->request->post('is_send'))
        {

            Config::saveConfig(
                [
                    'text1' => Yii::$app->request->post('text1', ''),
                    'text2' => Yii::$app->request->post('text2', ''),
                    'text3' => Yii::$app->request->post('text3', ''),
                    'text4' => Yii::$app->request->post('text4', ''),
                    'url1' => Yii::$app->request->post('url1', ''),
                    'url2' => Yii::$app->request->post('url2', ''),
                    'url3' => Yii::$app->request->post('url3', ''),
                    'url4' => Yii::$app->request->post('url4', ''),
                    'is_popup1' => Yii::$app->request->post('is_popup1', 0),
                    'is_popup2' => Yii::$app->request->post('is_popup2', 0),
                    'is_popup3' => Yii::$app->request->post('is_popup3', 0),
                    'is_popup4' => Yii::$app->request->post('is_popup4', 0),
                    'image1' => Config::loadPhoto('image1'),
                    'image2' => Config::loadPhoto('image2'),
                    'image3' => Config::loadPhoto('image3'),
                    'image4' => Config::loadPhoto('image4'),
                    'image1hover' => Config::loadPhoto('image1hover'),
                    'image2hover' => Config::loadPhoto('image2hover'),
                    'image3hover' => Config::loadPhoto('image3hover'),
                    'image4hover' => Config::loadPhoto('image4hover'),
                    'registration_email' => Yii::$app->request->post('registration_email', 'Click to link: #link# to complete registration'),
                    'registration_email_subject' => Yii::$app->request->post('registration_email_subject', 'Confirm Registration'),
                    'reset_password_email' => Yii::$app->request->post('reset_password_email', 'Click to link: #link# to reset password'),
                    'reset_password_subject' => Yii::$app->request->post('reset_password_subject', 'Reset password'),
                    'welcome_letter' => Yii::$app->request->post('welcome_letter', '')
                ], 'mainPage');
            $this->refresh();
        }

        $params['mainPage'] = Config::getConfig('mainPage',
            [
                'image1' => '',
                'text1' => '',
                'image2' => '',
                'text2' => '',
                'image3' => '',
                'text3' => '',
                'image4' => '',
                'text4' => '',
                'url1' => '',
                'url2' => '',
                'url3' => '',
                'url4' => '',
                'is_popup1' => 0,
                'is_popup2' => 0,
                'is_popup3' => 0,
                'is_popup4' => 0,
                'image1hover' => '',
                'image2hover' => '',
                'image3hover' => '',
                'image4hover' => '',
                'registration_email' => 'Click to link: #link# to complete registration',
                'registration_email_subject' => 'Confirm Registration',
                'reset_password_email' => 'Click to link: #link# to reset password',
                'reset_password_subject' => 'Reset password',
                'welcome_letter' => ''
            ]);
        return $this->render('config', ['params' => $params]);
    }

}
