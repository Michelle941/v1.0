<?php
/**
 * Created by PhpStorm.
 * User: mi
 * Date: 8/19/15
 * Time: 11:38 PM
 */

namespace app\models;

use Yii;
use yii\base\Model;

class Form extends Model{
    public $name;
    public $lastname;
    public $email;
    public $instagram;
    public $ticket_id;
    public $data = [];
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'lastname', 'email', 'ticket_id'], 'required','when' => function($model) {
                return $model->scenario == 'buyTicket';
            }],
            ['email', 'email'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'First Name',
            'lastname' => 'Last Name ',
            'email' => 'Email ',
            'ticket_id' => 'Ticket ',
            'instagram' => 'Instagram ',
        ];
    }
}