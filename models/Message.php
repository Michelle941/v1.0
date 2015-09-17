<?php

namespace app\models;

use Yii;

class Message extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_READ = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['re_id', 'user_from', 'user_to', 'status', 'created_at', 'read_at'], 'integer'],
            [['user_from', 'user_to', 'text', 'created_at'], 'required'],
            [['text'], 'string'],
            [['text'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            're_id' => 'Re ID',
            'user_from' => 'User From',
            'user_to' => 'User To',
            'status' => 'Status',
            'text' => 'Text',
            'created_at' => 'Created At',
            'read_at' => 'Read At',
        ];
    }

    public function createNotification()
    {
        $notification = New MailNotification(
            [
                'user_id' => $this->user_to,
                'object_id' => $this->id,
                'created_at' => time(),
                'type' => Notification::MAIL_NOTIFICATION
            ]
        );
        return $notification->save();
    }

    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'user_from']);
    }
    public function getReceiver()
    {
        return $this->hasOne(User::className(), ['id' => 'user_to']);
    }
    public $avatar, $total, $name;
    public static function getAllMessages($userId){

        $result = Message::find()
            ->with('sender')
            ->with('receiver')
            ->where(['user_from' => $userId])
            ->orWhere(['user_to' => $userId])
            ->orderBy("message.created_at DESC");

        $result->select('message.user_from, message.user_to, max(message.created_at) as created_at');

        $result->groupBy("message.user_from, message.user_to");

        return $result->all();
    }
    public function getMessages()
    {
        return self::_getMessages($this->user_from, $this->user_to);
    }
    public static function _getMessages($user_from, $user_to){

        $result = Message::find()
            ->with('sender')
            ->with('receiver')
            ->where(['user_from' => $user_from, 'user_to' => $user_to])
            ->orWhere(['user_from' => $user_to, 'user_to' => $user_from]);

        $result->select('message.*');

        $result->orderBy("message.created_at ASC");

        return $result->all();

    }
    public function getUnreadMessageCount($currentUser = 0){

        $fromUser = $this->user_from === $currentUser ? $currentUser: $this->user_from;
        return  Message::find()
            ->where(['user_from' => $fromUser, 'user_to' => $currentUser])
            ->andWhere('read_at is null')
            ->count();

    }
    public function readMessages(){

        $result = Message::find()
            ->with('sender')
            ->with('receiver')
            ->where(['user_from' => $this->user_from, 'user_to' => $this->user_to])
            ->orWhere(['user_from' => $this->user_to, 'user_to' => $this->user_from]);

        $result->select('message.*');

        $result->orderBy("message.created_at ASC");

        return $result->all();

    }
    public function getDate(){
        return date( 'M d Y', $this->created_at);
    }
    public function getCountStr($useId){
        $count = $this->getUnreadMessageCount($useId);
        if($count){
            return "($count new)";
        }
    }
    public function getText(){
        return (htmlspecialchars(trim($this->text)));
    }
}
