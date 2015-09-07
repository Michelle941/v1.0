<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification_task".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $from_user
 * @property string $user_list
 * @property string $value
 * @property string $dop_value
 */
class NotificationTask extends \yii\db\ActiveRecord
{
    const TYPE_MAIL = 1;
    const TYPE_MEMBER_UPDATE_PROFILE = 2;
    const TYPE_MEMBER_ADD_MORE_PHOTO = 3;
    const TYPE_MEMBER_BOUGHT_TICKET = 4;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'from_user', 'user_list'], 'required'],
            [['type', 'from_user'], 'integer'],
            [['user_list'], 'string'],
            [['value'], 'string'],
            [['dop_value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'from_user' => 'From User',
            'user_list' => 'User List',
            'value' => 'Value',
            'dop_value' => 'Dop Value',
        ];
    }
    public function createNotification(array $userTo = array())
    {
        foreach($userTo as $user_id){
            $notification = New MailNotification(
                [
                    'user_id' => $user_id,
                    'object_id' => $this->id,
                    'created_at' => time(),
                    'type' => Notification::MAIL_941_NOTIFICATION
                ]
            );
            $notification->save();
        }

    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user']);
    }

    private static function replace($str, $seed, $mask){
        foreach($mask as $key => $val){
            $str = str_replace($key, @$seed->$val, $str);
        }
        return $str;
    }
    public static function addMail(array $user_list, $value){

        $notification = new NotificationTask(
            [
                'type' => Notification::MAIL_941_NOTIFICATION,
                'from_user' => 0, //0 - admin 941
                'user_list' => implode('#', $user_list),
                'value' => $value,
            ]
        );
        if($notification->save()){
            $notification->createNotification($user_list);
        }
    }
    public static function findNotification($id)
    {
        return NotificationTask::find()
            ->where(['id' => $id])
            ->one();
    }
    public static function findNotification_($id)
    {
        return MailNotification::find()
            ->where(['id' => $id])
            ->one();
    }

    public function getMessage()
    {
        return $this->value;
    }

    public function getTitle()
    {
        return 'You have message from '.Yii::$app->params['serviceName'];
    }

    public function getContent($user)
    {
        return str_replace('#name#', $user->name, $this->value);
    }
    public function getDate()
    {
        return date( 'M d Y', $this->created_at);
    }

    public static function add($type, $value, $userId){
        $notification = new NotificationTask([
            'type' => $type,
            'from_user' => $userId,
            'value' => $value,
            'user_list' => implode('#', Following::getFollowers($userId))
        ]);
        $notification->save();
        UserNotification::saveNotification($userId,$notification->id, $type);
        return $notification;
    }
    public static function addUpdateProfile($userId, $value = 'Updated profile'){
        self::add(NotificationTask::TYPE_MEMBER_UPDATE_PROFILE, $value,  $userId);
    }
    public static function addPhoto($userId, $value = 'Added a new photo', $photoId = null){
        self::add(NotificationTask::TYPE_MEMBER_ADD_MORE_PHOTO, $value,  $userId);
    }
    public static function addTicket($userId, $value = 'Bought a ticket', $ticketId = null){
        self::add(NotificationTask::TYPE_MEMBER_BOUGHT_TICKET, $value,  $userId, $ticketId);
    }
    public function getPhotoUpdate()
    {
        return $this->hasOne(UserNotification::className(), [
            'user_id' => 'from_user',
            'object_id' => 'id'
        ]);
    }
    public function getProfileUpdate()
    {
        return $this->hasOne(UserNotification::className(), [
            'user_id' => 'from_user',
            'object_id' => 'id'
        ]);
    }
    private function getUpdateDate($time){
        return $this->time_elapsed_string($time);

    }
    public function getTime(){
        if($this->type === NotificationTask::TYPE_MEMBER_ADD_MORE_PHOTO){
            return $this->getUpdateDate($this->photoUpdate->created_at);
        }
        if($this->type === NotificationTask::TYPE_MEMBER_UPDATE_PROFILE){
            return $this->getUpdateDate($this->profileUpdate->created_at);
        }
        return $this->getUpdateDate($this->profileUpdate->created_at);
    }
    private $a = array(
        31536000 =>  'year',
        2592000 =>  'month',
        86400 =>  'day',
        3600 =>  'hour',
        60 =>  'minute',
        1 =>  'second',
    );
    private $a_plural = array( 'year'   => 'years',
        'month'  => 'months',
        'day'    => 'days',
        'hour'   => 'hours',
        'minute' => 'minutes',
        'second' => 'seconds'
    );
    function time_elapsed_string($ptime)
    {
        $etime = time() - $ptime;

        if ($etime < 1)
        {
            return '0 seconds';
        }

        foreach ($this->a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $this->a_plural[$str] : $str) . ' ago';
            }
        }
    }
}
