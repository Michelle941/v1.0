<?php

namespace app\models;

use app\models\User;
use Yii;
use yii\helpers\Url;

class UserNotification extends Notification
{
    const PHOTO_UPDATE = 0;
    const PROFILE_UPDATE = 1;
    const PARTY_UPDATE = 2;

    public static function findNotification($id)
    {
        return UserNotification::find()
            ->where(['id' => $id])
            ->with('user')
            ->one();
    }
    public static function saveNotification($user_id, $objId, $type, $subType = null)
    {
        $notification = New UserNotification(
            [
                'user_id' => $user_id,
                'subtype' => $subType,
                'object_id' => $objId,
                'created_at' => time(),
                'type' => $type
            ]
        );
        return $notification->save();

    }
    public static function createPhoto($user_id, $objId){
        return UserNotification::saveNotification($user_id, $objId, Notification::MEMBER_NOTIFICATION, self::PHOTO_UPDATE);
    }
    public static function createProfile($user_id, $objId){
        return UserNotification::saveNotification($user_id, $objId, Notification::MEMBER_NOTIFICATION, self::PROFILE_UPDATE);
    }
    public static function createTicket($user_id, $objId){
        return UserNotification::saveNotification($user_id, $objId, Notification::MEMBER_NOTIFICATION, self::PARTY_UPDATE);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'object_id']);
    }

    public function getTitle()
    {
       return $this->user->name.' '.$this->user->last_name.' update owner profile';
    }

    public function getContent()
    {
        return "<a href='".Url::to(['/site/member', 'id' => 'qt'.$this->user->id])."'><img src='/upload/50x50{$this->user->avatar}'></a>";
    }
}
