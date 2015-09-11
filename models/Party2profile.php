<?php

namespace app\models;

use Yii;
use app\models\User;

/*
    Добавляет админ или такую возможность получает тот, у кого есть билет на пати.
    Insert при покупки билета
 */

class Party2profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'party2profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'party_id', 'created_at'], 'required'],
            [['user_id', 'party_id', 'created_at'], 'integer']
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
            'party_id' => 'Party ID',
            'created_at' => 'Created At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getParty()
    {
        return $this->hasOne(Party::className(), ['id' => 'party_id']);
    }

    public static function findByUser($id, $page, $limit)
    {
        $result = Party2profile::find()
            ->with('party')
            ->where(['user_id' => $id]);
        $result->offset = $page;
        $result->limit = $limit;

        //Todo: order by?
        return $result->all();
    }
    public static function findByParty($party_id, $page = 0, $limit = 12)
    {
        $result = Party2profile::find()
            ->joinWith('user')
            ->where(['party_id' => $party_id])
            ->orderBy('user.rank ASC, user.view_count DESC')
        ;
        $result->offset = $page;
        $result->limit = $limit;

        //Todo: order by?
        return $result->all();
    }
    public static function countByUser($id)
    {
        $result = Party2profile::find()
            ->with('party')
            ->where(['user_id' => $id]);

        //Todo: order by?
        return $result->count();
    }

    public static function is_shared($party, $user)
    {
        return Party2profile::find()->where(['user_id' => $user, 'party_id' => $party])->exists();
    }

    public static function share($party, $user)
    {
        //если нужно, тут добавить логику, кому можно шарить пати к себе
        if(!self::is_shared($party, $user)){
            $p2u = new Party2profile(['user_id' => $user, 'party_id' => $party, 'created_at' => time()]);
            $p2u->save();
        }

    }

    public static function countByParty($partyID)
    {
        return Party2profile::find()->where(['party_id' => $partyID])->count();
    }
}
