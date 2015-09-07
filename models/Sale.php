<?php

namespace app\models;

use app\behaviors\TimeBehavior;
use developeruz\behaviors\ThumbBehavior;
use Yii;
use yii\web\UploadedFile;

class Sale extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sale';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['party_id', 'sale_type', 'created_at', 'started_at', 'finished_at'], 'required'],
            [['party_id', 'sale_type', 'created_at'], 'integer'],
            [['started_at', 'finished_at', 'top_text','bottom_text','bottom_text_8'], 'safe']
        ];
    }

    public function behaviors()
    {
        return  [
            'startTimeBehavior' => [
                'class' => TimeBehavior::className(),
                'dateTimeFields' => 'started_at',
            ],
            'endTimeBehavior' => [
                'class' => TimeBehavior::className(),
                'dateTimeFields' => 'finished_at',
            ],
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
            'sale_type' => 'Sale Type',
            'created_at' => 'Created At',
            'started_at' => 'Started At',
            'finished_at' => 'Finished At',
            'thumbnail' => 'Thumbnail',
            'mini_flyer' => 'Mini Flyer',
            'flyer_top' => 'Flyer Top',
            'flyer_bottom' => 'Flyer Bottom',
            'message_banner' => 'Message Banner',
            'top_text' => 'Top Text',
            'bottom_text' => 'Bottom Text',
            'bottom_text_8' => 'Bottom Text 8',

        ];
    }

    public static function getSaleType($type=null)
    {
        $saleType = [
            0 => 'Flash Sale',
            1 => 'Regular Sale'
        ];

        if(!is_numeric($type)) return $saleType;
        else return $saleType[$type];
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

    public function getTicket()
    {
        return $this->hasMany(TicketType::className(), ['sale_id' => 'id']);
    }
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['sale_id' => 'id']);
    }

    public function getParty()
    {
        return $this->hasOne(Party::className(), ['id' => 'party_id']);
    }


    public function getDashboardTitle($title = ''){

        if($this->sale_type !== 1){
            return "Flash Sale $title Sale Ends ". date('M d', strtotime($this->finished_at));
        }
        return  $title. ' - Limited tickets available';
    }
}
