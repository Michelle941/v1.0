<?php

namespace app\models;

use developeruz\behaviors\ThumbBehavior;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "ticket_type".
 *
 * @property integer $id
 * @property integer $sale_id
 * @property string $title
 * @property string $description
 * @property integer $quantity
 * @property string $price
 * @property string $image
 * @property integer $created_at
 */
class TicketType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sale_id', 'title', 'description', 'quantity', 'price', 'image', 'created_at'], 'required'],
            [['sale_id', 'quantity', 'created_at'], 'integer'],
            [['description'], 'string'],
            [['price', 'actual_price'], 'number'],
            [['title', 'image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sale_id' => 'Sale ID',
            'title' => 'Title',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'image' => 'Image',
            'created_at' => 'Created At',
            'actual_price' => 'Actual Price',
        ];
    }

    public function countAvailable()
    {
        $countSoldOut = Ticket::find()
            ->where(['ticket_type_id' => $this->id])
            ->count();
        return $this->quantity - $countSoldOut;
    }

    public function getSale()
    {
        return $this->hasOne(Sale::className(), ['id' => 'sale_id']);
    }

    public function loadPhoto($attribute)
    {
        $image = UploadedFile::getInstance($this, $attribute);
        if (!empty($image)) {
            $uniqName = Yii::$app->security->generateRandomString() . '.' . $image->getExtension();
            if ($image->saveAs(Yii::$app->basePath . Yii::$app->params['flayerUploadDir'] . $uniqName)) {
                $this->{$attribute} = $uniqName;
            }
        }
    }
    public $total;
    public static function getSummery($partyId)
    {
        $sql = 'SELECT count(1) as total, tt.*
                FROM ticket t
                LEFT JOIN ticket_type tt ON t.ticket_type_id = tt.id
                where t.party_id = %d
                GROUP by t.ticket_type_id'
        ;

        return self::findBySql(sprintf($sql,$partyId))->all();
    }
}
