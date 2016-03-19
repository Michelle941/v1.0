<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "likes".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $photo_id
 * @property integer $created_at
 */
class Likes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'likes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'photo_id', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer']
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
            'photo_id' => 'Photo ID',
            'created_at' => 'Created At',
        ];
    }

    public static function is_liked($id)
    {
        return Likes::find()->where(['photo_id' => $id, 'user_id' => Yii::$app->user->getId()])->exists();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function countLike($id)
    {
        return Likes::find()->where(['photo_id' => $id])->count();
    }

    public static function getLikes($id)
    {
        return Likes::find()
            ->where(['photo_id' => $id])
            ->with('user')
            ->limit(6)->all();
    }
}
