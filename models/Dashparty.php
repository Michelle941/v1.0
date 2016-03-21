<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Dashparty extends ActiveRecord
{
    public static function tableName()
    {
        return 'dashparty';
    }
    public function rules()
    {
        return [
            [['user_id','party_id','going_flag'], 'required'],
        ];
    }

    public static function checkExists($userID, $partyID)
    {
        return self::getOne($userID, $partyID);
    }
    public static function getOne($userID, $partyID){
        return Dashparty::find()->where(['user_id' => $userID])->andWhere(['party_id' => $partyID])->one();
    }

    public static function getAll($userID){
        $return = [];

        foreach(Dashparty::find()->where(['user_id' => $userID])->all() as $row){
            $return[$row->party_id] = $row;
        }
        return $return;
    }
}
