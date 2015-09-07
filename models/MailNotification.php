<?php

namespace app\models;

use Yii;

class MailNotification extends Notification
{

    public static function findNotification($id)
    {
        return MailNotification::find()
            ->where(['id' => $id])
            ->with('message.sender')
            ->one();
    }

    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'object_id']);
    }

    public function getTitle()
    {
        if($this->message->user_from == 0)
        {
            return 'You have message from '.Yii::$app->params['serviceName'];
        }
        else if(isset($this->message->sender))
            return 'You have message from '.$this->message->sender->name.' '.$this->message->sender->last_name;
    }
    public function getSender()
    {
        return (isset($this->message->sender)) ?$this->message->sender : null;
    }

    public function getContent()
    {
        if(Yii::$app->user->can('premium') || $this->message->user_from == 0)
        {
            echo Yii::$app->controller->renderPartial('/notice/message', ['message' => $this->message]);
        }
        else {
            echo Yii::$app->controller->renderPartial('/notice/buy_premium');
        }
    }
}
