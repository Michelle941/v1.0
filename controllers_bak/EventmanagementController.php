<?php

namespace app\controllers;

use app\models\Party;
use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\Ticket;
use app\models\TicketType;
use yii\data\ActiveDataProvider;
use app\components\ButtonUpdateDelete;

class EventmanagementController extends Controller
{
    public $layout = 'manager';

    public function actionIndex(){
        $session = Yii::$app->session;
        $partyId = $session->get('party_id');
        if(empty($partyId)){
            $this->redirect('/eventmanagement/login');
        }
        return $this->render('index', [
            'model' =>  new Ticket(),
            'party' => $session->get('party'),
            'partyId' => $session->get('party_id'),
            'adminType' => $session->get('sessionType'),
            'summary' => TicketType::getSummery($partyId),
        ]);
    }
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            $type = null;
            if($party = Party::find()->where(['username' => $model->username, 'password' => $model->password])->one()){
                $type = 'staff';
            }elseif($party = Party::find()->where(['username' => $model->username, 'manager_password' => $model->password])->one()){
                $type = 'manager';
            }

            if($party){
                $session = Yii::$app->session;
                $session->set('party_id', $party->id);
                $session->set('party', $party);
                $session->set('sessionType', $type);
                $this->redirect('/eventmanagement/index?sort=id');
                return $this->actionIndex();
            }
        }
        return $this->renderPartial('login', ['model' => $model]);
    }
    public function actionCheckin($id){
        if($ticket = Ticket::find()->where(['id' => $id])->one()){
            $ticket->checked = 1;
            $ticket->save();
            $this->redirect('/eventmanagement/index?sort=id');
            return $this->actionIndex();
        }
    }
    public function actionCheckout($id){

        if($ticket = Ticket::find()->where(['id' => $id])->one()){
            $ticket->checked = 0;
            $ticket->save();
            $this->redirect('/eventmanagement/index?sort=id');
            return $this->actionIndex();
        }
    }
}
