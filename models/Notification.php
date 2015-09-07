<?php

namespace app\models;

use app\models\User;
use Yii;

class Notification extends \yii\db\ActiveRecord
{
    const MAIL_941_NOTIFICATION = 0;
    const MAIL_NOTIFICATION = 1;
    const PARTY_NOTIFICATION = 2;
    const TICKET_NOTIFICATION = 3;
    const MEMBER_NOTIFICATION = 4;
    const PHOTO_NOTIFICATION = 5;
    const PROFILE_NOTIFICATION = 6      ;

    public $total;
    public $avatar;
    public $name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'object_id', 'type', 'created_at'], 'required'],
            [['user_id', 'object_id', 'type', 'created_at', 'is_read'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'object_id' => 'Object ID',
            'type' => 'Type',
            'created_at' => 'Created At',
            'is_read' => 'Is Read',
        ];
    }

    public function getNotification()
    {
        //возвращает объект наследник в зависимости от типа
        if($this->type == Notification::MAIL_NOTIFICATION)
        {
            return MailNotification::findNotification($this->id);
        }
        if($this->type == Notification::MAIL_941_NOTIFICATION)
        {
            return NotificationTask::findNotification($this->object_id);
        }
        elseif($this->type == Notification::MEMBER_NOTIFICATION)
        {
            return UserNotification::findNotification($this->id);
        }

    }
    public static function createNotification($user_id, $objId, $type)
    {
        $notification = New MailNotification(
            [
                'user_id' => $user_id,
                'object_id' => $objId,
                'created_at' => time(),
                'type' => $type
            ]
        );
        $notification->save();

    }
    public function getDate(){
        return date( 'M d Y', $this->created_at);
    }

    public static function getMessageNotifications($userId){
        $sql = 'SELECT n.*, count(n.id) as total, max(n.created_at) as time, u.avatar as avatar, u.name as name
                FROM notification n
                JOIN user u on u.id = n.user_id
                where type != 0 and n.user_id !=%d
                GROUP BY user_id
                ORDER BY time DESC
                ';

        return self::findBySql(sprintf($sql,$userId ))->all();
    }
}
