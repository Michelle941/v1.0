<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $group
 * @property string $name
 * @property string $value
 * @property string $type
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group', 'name', 'value'], 'required'],
            [['group', 'name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group' => 'Group',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

    public static function saveValue($group, $name, $value)
    {
        $config = new Config();
        $config->group = $group;
        $config->name = $name;
        $config->value = $value;
        return $config->save();
    }

    public static function getValue($group, $name)
    {
        $result = Config::findOne(['group' => $group, 'name' => $name]);
        if($result instanceof Config) return $result->value;
        else return null;
    }

    public static function getConfigGroup($group)
    {
        $result = Config::find()->where(['group' => $group])->all();
        return ArrayHelper::map($result, 'name', 'value');
    }

    public static function updateValue($group, $name, $value)
    {
        $config = Config::findOne(['group' => $group, 'name' => $name]);
        $config->value = $value;
        $config->save();
    }

    public static function deleteValue($group, $name)
    {
        return Config::findOne(['group' => $group, 'name' => $name])->delete();
    }

    public static function saveConfig($array, $group)
    {
        $config = Yii::$app->config;

        foreach($array as $key => $value)
        {
            if(!is_null($config->getValue($group, $key)))
                $config->updateValue($group, $key, $value);

            else $config->saveValue($group, $key, $value);
        }
    }

    public static function getConfig($group, $defaultParams)
    {
        $config = Yii::$app->config;
        $array = $config::getConfigGroup($group);

        foreach($defaultParams as $key => $defaultValue)
        {
            if(array_key_exists($key, $array))
                $defaultParams[$key] = $array[$key];
        }
        return $defaultParams;
    }

    public static function loadPhoto($name)
    {
        $image = UploadedFile::getInstanceByName($name);
        if (!empty($image)) {
            $uniqName = Yii::$app->security->generateRandomString() . '.' . $image->getExtension();
            if ($image->saveAs(Yii::$app->basePath . Yii::$app->params['flayerUploadDir'] . $uniqName)) {
                return $uniqName;
            }
        }
        else return '';
    }
}
