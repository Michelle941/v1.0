<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_group".
 *
 * @property integer $id
 * @property string $title
 * @property integer $created_at
 */
class UserGroup extends \yii\db\ActiveRecord
{
    public $kol;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'created_at'], 'required'],
            [['created_at'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'kol' => 'Number of users',
            'created_at' => 'Created At',
        ];
    }

    public static function search()
    {
        return new ActiveDataProvider([
            'query' => UserGroup::find()
            ->with('users'),
        ]);
    }

    public function getUsers()
    {
        return $this->hasMany(User2group::className(), ['group_id' => 'id']);
    }

    public static function getAsArray()
    {
        $result = ArrayHelper::map(UserGroup::find()->all(), 'id', 'title');
        $result[-1] = 'All';
        ksort($result);
        return $result;
    }
}
