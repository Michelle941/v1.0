<?php

namespace app\models;

use app\behaviors\ModelBehavior;
use app\behaviors\TimeBehavior;
use yii\web\UploadedFile;
use Yii;

class Party extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'party';
    }

    public function rules()
    {
        return [
            [['title', 'username', 'password', 'manager_password', 'ticket_prefix', 'description', 'created_at', 'started_at', 'url', 'location', 'finished_at', 'rank', 'tags'], 'required'],
            [['allow2sharing', 'allow2add_photo', 'highlight', 'status'], 'boolean'],
            [['lon', 'lat'], 'number'],
            [['url'], 'match', 'pattern' => '/[a-zA-Z0-9_-]+/',],
            [['url'], 'unique'],
            [['title', 'description', 'location'], 'string', 'max' => 255],
            [['allow2sharing', 'allow2add_photo', 'highlight', 'account_note'], 'safe']

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Party name',
            'created_at' => 'Created At',
            'started_at' => 'Started At',
            'url' => 'Url',
            'location' => 'Location (string)',
            'lon' => 'Lon',
            'lat' => 'Lat',
            'finished_at' => 'Finished At',
            'allow2sharing' => 'Allow sharing party to user profile',
            'allow2add_photo' => 'Allow add photo to party page',
            'highlight' => 'Highlight party',
            'status' => 'Status',
            'rank' => 'Rank',
            'tags' => 'Search tags',
            'account_note' => 'Account Notes',
            'username' => 'Username',
            'password' => 'Password',
            'manager_password' => 'Manager\'s Password',
            'ticket_prefix' => 'Ticket Number Prefix',
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
            'startTimeBehavior' => [
                'class' => TimeBehavior::className(),
                'dateTimeFields' => 'started_at',
            ],
            'endTimeBehavior' => [
                'class' => TimeBehavior::className(),
                'dateTimeFields' => 'finished_at',
            ]
        ];
    }

    public function getParty2profile()
    {
        return $this->hasMany(Party2profile::className(), ['party_id' => 'id']);
    }

    public function getContact()
    {
        return $this->hasMany(PartyContact::className(), ['party_id' => 'id']);
    }

    public function getStaff()
    {
        return $this->hasMany(Staff2party::className(), ['party_id' => 'id']);
    }

    public function getPhoto()
    {
        return $this->hasMany(Photo::className(), ['party_id' => 'id']);
    }

    public function getPublicPhoto()
    {
        return $this->hasMany(Photo::className(), ['party_id' => 'id'])->where(['photo.status' => 1]);
    }

    public function getSale()
    {
        return $this->hasOne(Sale::className(), ['party_id' => 'id']);
    }
    public function getSales()
    {
        return $this->hasMany(Sale::className(), ['party_id' => 'id']);
    }
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['party_id' => 'id']);
    }

    protected static function dumpSql($query)
    {
        var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);
    }

    public static function search($dop = '')
    {
        $query = Party::find();
        $is_future = 'started_at > UNIX_TIMESTAMP() /* AS is_future */';
        $max_int = '4294967295 /* AS max_int */ ';

        $orderByExpression = new \yii\db\Expression("$is_future DESC, IF($is_future, started_at, $max_int - started_at)");
        return $query->where(['status' => 1])->orderBy([$orderByExpression]);
    }
    public static function searchNew($search)
    {
        $query = Party::find();
        $query->where(['status' => 1]);
        if(!empty($search['search'])){
            $query->andWhere("title like '%{$search['search']}%'  or tags like '%{$search['search']}%'");
        }
        return $query->orderBy('rank');
    }

    public static function findHighlighed()
    {
        return self::search()->andWhere(['highlight' => 1])->all();
    }

    public static function classicSearch()
    {
        return Party::find()->where(['status' => 1]);
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

    public static function getBanners($id)
    {
        /*
         Ищем сейл, если его нет - отдаем с прощедшей пати
         если есть - отдаем с сейла
         */
        $sale = Sale::find()
            ->where(['<=', 'started_at', time()])
            ->andWhere(['>=', 'sale.finished_at', time()])
            ->andWhere(['party_id' => $id])
            ->one();
        if($sale instanceof Sale)
            $obj = $sale;
        else {
            $obj = Party::findOne($id);
        }
        return [
            'thumbnail' => $obj->thumbnail,
            'mini_flyer' => $obj->mini_flyer,
            'flyer_top' => $obj->flyer_top,
            'flyer_bottom' => $obj->flyer_bottom,
            'message_banner' => $obj->message_banner,
	    'party_first' => $obj->party_first,
	    'party_last' => $obj->party_last,
	    'party_more' => $obj->party_more
        ];
    }
}
