<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "statistic".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $obj_id
 * @property integer $created_at
 * @property string $ip
 */
class Statistic extends \yii\db\ActiveRecord
{
    const TYPE_PROFILE_VIEWS = 1;
    const TYPE_PHOTO_VIEWS = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statistic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'created_at'], 'integer'],
            [['obj_id', 'created_at'], 'required'],
            [['ip'], 'string', 'max' => 255]
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
            'obj_id' => 'Obj ID',
            'created_at' => 'Created At',
            'ip' => 'Ip',
        ];
    }

    public static function countByType($objectID, $type)
    {
        $count = Statistic::find()->where(['obj_id' => $objectID, 'type' => $type])->count();
        return $count-1; //Avoid the first count
    }

    public static function countPlusOne($objectID, $type)
    {
        $stat = new Statistic([
            'obj_id' => $objectID,
            'type' => $type,
            'created_at' => time(),
            'ip' => $_SERVER['REMOTE_ADDR']
        ]);
        return $stat->save();
    }
}
