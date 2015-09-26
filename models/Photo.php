<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;

/*
  Если party_id =0 то фотка загружена юзером в свой профайл. Ее нельзя шарить.
 */

class Photo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['load_user_id', 'created_at', 'image', 'party_id'], 'required'],
            [['load_user_id', 'created_at', 'allow2sharing', 'allow2comment', 'party_id', 'status'], 'integer'],
            [['image', 'comment'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'load_user_id' => 'Load User ID',
            'created_at' => 'Created At',
            'image' => 'Image',
            'allow2sharing' => 'Allow2sharing',
            'allow2comment' => 'Allow2comment',
            'party_id' => 'Party ID',
            'comment' => 'Comment',
            'status' => 'Status',
        ];
    }

    public function loadPhoto($attribute)
    {
        $image = UploadedFile::getInstanceByName($attribute);
        if (!empty($image)) {
            $uniqName = Yii::$app->security->generateRandomString() . '.' . $image->getExtension();
            if ($image->saveAs(Yii::$app->basePath . Yii::$app->params['imageUploadDir'] . $uniqName)) {
                $this->makePreview($uniqName, Yii::$app->params['previewSize'], [], $image->getExtension());
                return $uniqName;
            }
        }
    }
    public function loadImage($attribute)
    {
        $image = UploadedFile::getInstance($this, $attribute);
        if (!empty($image)) {
            $uniqName = Yii::$app->security->generateRandomString() . '.' . $image->getExtension();
            if ($image->saveAs(Yii::$app->basePath . Yii::$app->params['imageUploadDir'] . $uniqName)) {
                $this->makePreview($uniqName, Yii::$app->params['previewSize'], Yii::$app->params['previewSizeSquare'], $image->getExtension());
                $this->$attribute =  $uniqName;
            }
        }
    }

    public function loadInstagramPhoto($url, $attribute)
    {
        $uniqueName = Yii::$app->security->generateRandomString() . '.jpg';
        $path = Yii::$app->basePath . Yii::$app->params['imageUploadDir'];  // your saving path
        $ch = curl_init($url);
        $fp = fopen($path . $uniqueName, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        $this->makePreview($uniqueName, Yii::$app->params['previewSize'], Yii::$app->params['previewSizeSquare']);
        return $this->{$attribute} = $uniqueName;
    }

    protected function makePreview($file, $sizesSquares = array(), $sizes = array(), $type = 'jpg')
    {
        Photo::rotateIos($file, $type);
        foreach($sizesSquares as $size) {
            Image::thumbnail(Yii::$app->basePath . Yii::$app->params['imageUploadDir'] . $file, $size[0], $size[1])
                ->save(Yii::$app->basePath . Yii::$app->params['imageUploadDir'] . $size[0] . 'x' . $size[1].'_square' . $file);
        }
        foreach($sizes as $size) {
            Image::thumbnail(Yii::$app->basePath . Yii::$app->params['imageUploadDir'] . $file, $size[0], $size[1], 'inset')
                ->save(Yii::$app->basePath . Yii::$app->params['imageUploadDir'] . $size[0] . 'x' . $size[1] . $file);
        }
    }
    public static function saveImage($userId, $image, $partyId = 0){
        $photo = new self();
        $photo->party_id = $partyId;
        $photo->load_user_id = $userId;
        $photo->created_at = time();
        $photo->image = $image;
        $photo->save();
        return $photo->id;
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'load_user_id']);
    }

    public function getParty()
    {
        return $this->hasOne(Party::className(), ['id' => 'party_id']);
    }

    public function getShare()
    {
        return $this->hasOne(SharingPhoto::className(), ['user_id' => 'load_user_id', 'obj_id' => 'id']);
    }

    public static function countUserCustomPhoto($userID)
    {
        return Photo::find()->where(['load_user_id' => $userID, 'party_id' => 0])->count();
    }

    public static function countPartyPhotos($partyID,  $exclude = [])
    {
        $exclude = is_array($exclude)? implode(',', $exclude) : $exclude;
        $exclude = empty($exclude)? 0 : $exclude;

        return Photo::find()->where(['party_id' => $partyID])->andWhere("id not in ($exclude)")->andWhere("deleted_party <> 1")->count();
    }
    public static function getPartyPhotos($partyID, $limit = 5, $start = 0, $exclude = [])
    {
        $exclude = is_array($exclude)? implode(',', $exclude) : $exclude;
        $exclude = empty($exclude)? 0 : $exclude;

        return Photo::find()
            ->where(['party_id' => $partyID])
            ->andWhere("id not in ($exclude)")
            ->andWhere("(deleted_party =0 or deleted_party is NULL)")
            ->orderBy('view_count DESC')
            ->limit($limit)
            ->offset($start)
            ->all();
            ;
    }

    public static function getPartyNewPhotos($partyID, $limit = 5, $start = 0, $exclude = [])
    {
        $exclude = is_array($exclude)? implode(',', $exclude) : $exclude;
        $exclude = empty($exclude)? 0 : $exclude;
        return Photo::find()
            ->where(['party_id' => $partyID])
            ->andWhere("id not in ($exclude) and (deleted_party =0 or deleted_party is NULL)")
            ->orderBy('id DESC')
            ->limit($limit)
            ->offset($start)
            ->all();
        ;
    }

    public static function getUserPhotos($userId, $start = 0,  $limit = 5)
    {
        return Photo::find()
            ->where(['load_user_id' => $userId])
            ->andWhere('(deleted_party =0 or deleted_party is NULL)')
            ->orderBy('view_count DESC ')
            ->limit($limit)
            ->offset($start)
            ->all();
        ;
    }
    public static function getPhotos($userId, $start = 0,  $limit = 5, $exclude = array())
    {
        $exclude = is_array($exclude) ? implode(', ',$exclude):  $exclude;
        $notIn = empty($exclude) ? '' : ' and p.id  not in ('.$exclude.')';
        $sql = 'SELECT p.*
                FROM photo p
                LEFT JOIN sharing_photo sp ON sp.obj_id = p.id  AND sp.type = 0
                where ((`load_user_id` = %d and (deleted_user =0 or deleted_user is NULL) ) or  sp.user_id =%d) %s
                ORDER by p.view_count DESC
                LIMIT %d OFFSET %d';
        return photo::findBySql(sprintf($sql,$userId, $userId, $notIn, $limit, $start ))->all();
    }

    public static function getPhotoCounts($userId, $exclude = array())
    {
        $exclude = is_array($exclude) ? implode(', ',$exclude):  $exclude;
        $notIn = empty($exclude) ? '' : ' and p.id  not in ('.$exclude.')';
        $sql = 'SELECT p.*
                FROM photo p
                LEFT JOIN sharing_photo sp ON sp.obj_id = p.id  AND sp.type = 1
                where ((`load_user_id` = %d and (deleted_user =0 or deleted_user is NULL) )  or  sp.user_id =%d) %s ';

        return photo::findBySql(sprintf($sql,$userId, $userId, $notIn))->count();
    }


    public static function getUserNewPhotos($userId, $start = 0,  $limit = 5)
    {
        return Photo::find()
            ->where(['load_user_id' => $userId])
            ->andWhere('(deleted_user =0 or deleted_user is NULL)')
            ->orderBy('id DESC ')
            ->limit($limit)
            ->offset($start)
            ->all();
        ;
    }


    public static function findProfilePhoto($userID)
    {
        return Photo::find()->where(['load_user_id' => $userID, 'party_id' => 0])->andWhere('(deleted_user =0 or deleted_user is NULL)')->all();
    }

    public static function getOne($id)
    {
        return Photo::find()
            ->where(['id' => $id])
            ->andWhere('(deleted_user =0 or deleted_user is NULL)')
            ->one();
        ;
    }
    public static function rotateIos($uniqueName, $type){

        if($type !== 'jpg'){
            return ;
        }
        $target = Yii::$app->basePath . Yii::$app->params['imageUploadDir'] . $uniqueName;
        $buffer = ImageCreateFromJPEG($target);
        $exif = exif_read_data($target);
        if(!empty($exif['Orientation'])){
            switch($exif['Orientation']){
                case 8:
                    $buffer = imagerotate($buffer,90,0);
                    break;
                case 3:
                    $buffer = imagerotate($buffer,180,0);
                    break;
                case 6:
                    $buffer = imagerotate($buffer,-90,0);
                    break;
            }
        }

        imagejpeg($buffer, $target, 90);
    }

}
