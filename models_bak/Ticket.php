<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class Ticket extends \yii\db\ActiveRecord
{
    const STATUS_OK = 1;
    const STATUS_CANCEL = 0;

    private static $status = [1 => 'Active', 2=>'Checked', 3 => 'Cancelled'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['party_id', 'user_id', 'bought_at', 'hash', 'ticket_type_id'], 'required'],
            [['party_id', 'user_id', 'bought_at', 'ticket_type_id'], 'integer'],
            [['hash'], 'string', 'max' => 255],
            [['party_id', 'user_id', 'bought_at', 'hash', 'ticket_type_id', 'status'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'party_id' => 'Party ID',
            'user_id' => 'User ID',
            'bought_at' => 'Bought At',
            'hash' => 'Hash',
            'ticket_type_id' => 'Ticket Type ID',
        ];
    }

    public function getParty()
    {
        return $this->hasOne(Party::className(), ['id' => 'party_id']);
    }
    public function getDetail()
    {
        return $this->hasOne(TicketType::className(), ['id' => 'ticket_type_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function search($model)
    {
        $query = Ticket::find()
            ->joinWith('party')
            ->joinWith('user');

        $query->andFilterWhere([
            'ticket.status' => $model->status
        ]);

        $query->andFilterWhere(['like', 'hash', $model->hash])
            ->andFilterWhere(['like', 'party.title', $model->party_id])
            ->andFilterWhere(['like', 'CONCAT(user.name," ", user.last_name)', $model->user_id]);

        return new ActiveDataProvider([
                'query' => $query,
                'sort'  => ['defaultOrder' => ['bought_at' => 'DESC']]
            ]);
    }

    public static function generateHash($invoice_number, $amount)
    {
        $string = $invoice_number.'#'.$amount;
        return Yii::$app->security->generatePasswordHash($string);
    }
    public function getStatus(){
        return @self::$status[$this->status];
    }
    public static function notification($users){
        if(empty($users)){
            return [];
        }
        $users = implode(',', $users);
        return Ticket::find()
            ->with('party')
            ->with('detail')
            ->with('user')
            ->where("user_id in ($users)")->all() ;
    }
    public static function getUsers($partyId, $limit = 6){
        return Ticket::find()
            ->joinWith('user')
            ->where(['party_id' => $partyId])
            ->andWhere('user_id > 0')
            ->orderBy('user.rank ASC, id DESC')
            ->limit($limit)
            ->all() ;
    }
    public static function getUserTickets($userId){
        return Ticket::find()
            ->with('party', 'user', 'detail')
            ->where(['user_id' => $userId])
            ->all();
    }

    public static function dp($partyId)
    {
        $query = self::find()
            ->with('party','user', 'detail')
            ->where(['party_id' => $partyId])
            ->andWhere('checked = 0 or checked is null');


        $dp = new ActiveDataProvider([
            'query' => $query,
            'sort'  => ['defaultOrder' => ['id' => 'ASC']]
        ]);
        $dp->pagination->pageSize = $query->count();
        return $dp;
    }

    public static function dpChecked($partyId)
    {
        $query = self::find()
            ->with('party','user', 'detail')
            ->where(['party_id' => $partyId, 'checked' => 1]);


        $dp = new ActiveDataProvider([
            'query' => $query,
            'sort'  => ['defaultOrder' => ['id' => 'ASC']]
        ]);
        $dp->pagination->pageSize = $query->count();
        return $dp;
    }

}
