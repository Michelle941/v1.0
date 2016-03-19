<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_settings".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $value
 */
class UserSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'value'], 'required'],
            [['user_id'], 'integer'],
            [['name', 'value'], 'string', 'max' => 255]
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
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

    public static function getValue($user_id, $name)
    {
        $result = UserSettings::findOne(['user_id' => $user_id, 'name' => $name]);
        if($result instanceof UserSettings) return $result->value;
        else return null;
    }

    public static function getSettings($user_id, $name)
    {
        $result = UserSettings::findOne(['user_id' => $user_id, 'name' => $name]);
        if($result instanceof UserSettings) return $result;
        else return null;
    }

    public static function saveValue($user_id, $name, $value)
    {
        $lastValue = UserSettings::getSettings($user_id, $name);
        if($lastValue === null) {
            $config = new UserSettings();
            $config->user_id = $user_id;
            $config->name = $name;
            $config->value = $value;
            return $config->save();
        }
        else {
            $lastValue->value = $value;
            return $lastValue->save();
        }
    }
}
