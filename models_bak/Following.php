<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "following".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $follow_to
 * @property integer $created_at
 */
class Following extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'following';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'follow_to', 'created_at'], 'required'],
            [['user_id', 'follow_to', 'created_at'], 'integer']
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
            'follow_to' => 'Follow To',
            'created_at' => 'Created At',
        ];
    }

    public static function checkFollow($userID)
    {
        return Following::find()->where(['user_id' => Yii::$app->user->getId(), 'follow_to' => $userID])->exists();
    }

    public static function countFollowing($userID)
    {
        return Following::find()->where(['follow_to' => $userID])->count();
    }

    public static function getFollowers($userID)
    {
        return Following::find()->select('user_id')->where(['follow_to' => $userID])->column();
    }
    public static function getFollows($userID)
    {
        return Following::find()->select('follow_to')->where(['user_id' => $userID])->column();
    }
}
