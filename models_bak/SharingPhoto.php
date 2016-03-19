<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sharing_photo".
 *
 * @property integer $id
 * @property integer $obj_id
 * @property integer $created_at
 * @property integer $user_id
 * @property string $comment
 */
class SharingPhoto extends \yii\db\ActiveRecord
{

    const TYPE_PARTY = 0;
    const TYPE_CUSTOM_USER = 1;

    public $kol;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sharing_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['obj_id', 'created_at', 'user_id'], 'required'],
            [['obj_id', 'created_at', 'user_id'], 'integer'],
            [['comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'obj_id' => 'Obj ID',
            'created_at' => 'Created At',
            'user_id' => 'User ID',
            'comment' => 'Comment',
        ];
    }

    public static function is_share($id)
    {
        return SharingPhoto::find()->where(['obj_id' => $id, 'user_id' => Yii::$app->user->getId()])->exists();
    }

    public static function share($photo, $comment='', $type = SharingPhoto::TYPE_PARTY)
    {
        if(!SharingPhoto::is_share($photo->id) && $photo->allow2sharing){
            $share = new SharingPhoto();
            $share->obj_id = $photo->id;
            $share->user_id = Yii::$app->user->getId();
            $share->created_at = time();
            $share->type = $type;
            if($photo->allow2comment)
            {
                $share->comment = $comment;
            }
            if($share->save())
            {
                return true;
            }
        }
        return false;
    }

    public static function findByUser($id,  $page, $limit) //сортировка по кол-ву просмотров
    {
        $result = SharingPhoto::find()
            ->joinWith('statistic')
            ->with('photo')
            ->where(['user_id' => $id]);

        $result->select('sharing_photo.*');
        $result->addSelect('count(*) as kol');

        $result->offset = $page;
        $result->limit = $limit;
        $result->groupBy("sharing_photo.obj_id");
        $result->orderBy("kol DESC");

        return $result->all();
    }

    public function getStatistic()
    {
        return $this->hasMany(Statistic::className(), ['obj_id' => 'obj_id']);
    }

    public function getPhoto()
    {
        return $this->hasOne(Photo::className(), ['id' => 'obj_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function countShare($id)
    {
        return SharingPhoto::find()->where(['obj_id' => $id])->count();
    }

    public static function getShares($id)
    {
        return SharingPhoto::find()
            ->where(['obj_id' => $id, 'type' => 0])
            ->with('user')
            ->all();
    }
    public static function haveShared($id, $userId){
        return SharingPhoto::find()
            ->where(['obj_id' => $id, 'user_id' => $userId, 'type' => 0])
            ->andWhere(['user_id' => $userId])
            ->count();
    }
}
