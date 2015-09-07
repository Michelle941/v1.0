<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user2group".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $group_id
 */
class User2group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user2group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'group_id'], 'required'],
            [['user_id', 'group_id'], 'integer']
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
            'group_id' => 'Group ID',
        ];
    }

    public static function add($userID, $groupID)
    {
        if(! User2group::find()->where(['user_id' => $userID, 'group_id' => $groupID])->exists() )
        {
            $u2g = new User2group(['user_id' => $userID, 'group_id' => $groupID]);
            return $u2g->save();
        }
        return false;
    }

    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function findAllFromGroup($groupID)
    {
        return User2group::find()->select('user_id')->where(['group_id' => $groupID])->column();
    }
}