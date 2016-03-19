<?php

namespace app\models;

use app\behaviors\ModelBehavior;
use Yii;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property string $text
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'title', 'text'], 'required'],
            [['text'], 'string'],
            [['url', 'title'], 'string', 'max' => 255],
            ['url', 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'title' => 'Title',
            'text' => 'Text',
        ];
    }

    public function behaviors()
    {
        return  [
            'ModelBehavior' => [
                'class'       => ModelBehavior::className(),
                'order' => 'id',
                'orderType' => SORT_DESC
            ],
        ];
    }
}
