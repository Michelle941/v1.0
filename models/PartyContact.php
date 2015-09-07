<?php

namespace app\models;

use Yii;
use app\behaviors\ModelBehavior;

/**
 * This is the model class for table "party_contact".
 *
 * @property integer $id
 * @property integer $party_id
 * @property string $name
 * @property string $organization
 * @property string $email
 * @property string $phone
 */
class PartyContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'party_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['party_id', 'name', 'organization', 'email', 'phone'], 'required'],
            [['party_id'], 'integer'],
            [['name', 'organization', 'email', 'phone'], 'string', 'max' => 255]
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
            'name' => 'Name',
            'organization' => 'Organization',
            'email' => 'Email',
            'phone' => 'Phone',
        ];
    }

    public function behaviors()
    {
        return  [
            'ModelBehavior' => [
                'class'       => ModelBehavior::className(),
                'order' => 'id',
                'orderType' => SORT_DESC
            ]
        ];
    }
}
