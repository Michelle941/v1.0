<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\web\IdentityInterface;
use yii\imagine\Image;


class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_EMAIL_NOT_CONFIRM = 5;
    const STATUS_EMAIL_CONFIRM = 6;
    const STATUS_SING_UP_FROM_FACEBOOK = 9;
    const STATUS_ACTIVE = 10;

    public $password;
    public $password_repeat;
    public $role;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'status', 'password'], 'required'],
            ['email', 'unique'],
            ['dob', 'required','when' => function($model) {
                return $model->scenario == 'step2';
            }],
            ['dob', 'validateDob','when' => function($model) {
                return $model->scenario == 'step2';
            }],
            ['email', 'email'],
            [['password'], 'string', 'min' => 6, 'tooShort' => 'Weak sauce'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message'=>"OOPS. PASSWORDS DON'T MATCH. TRY AGAIN"],
            [['name', 'last_name', 'city', 'region', 'state', 'zip_code', 'relation_status', 'gender', 'work', 'love', 'tag_line', 'password_repeat', 'password'], 'safe']
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['step2'] = ['dob', 'city', 'region', 'state', 'zip_code', '!avatar'];
        $scenarios['step2FB'] = ['name', 'last_name', 'password', 'password_repeat', 'dob', 'city', 'region', 'state', 'zip_code', 'avatar'];
        $scenarios['step3'] = ['status'];
        $scenarios['find'] = ['name', 'last_name', 'dob', 'city', 'region', 'state', 'zip_code', '!email',
            'gender', 'rank', 'relation_status', 'tag_line', 'premium_status', 'premium_type', 'premium_start_date',
            'premium_end_date', 'work', 'love', 'role'
        ];
        $scenarios['edit'] = ['name', 'last_name', 'email', 'rank'];
        $scenarios['reset'] = ['password', 'password_repeat'];
        $scenarios['view_count'] = ['view_count'];
        $scenarios['instagram'] = ['instagram_token', 'instagram_user_id'];
        $scenarios['photo1'] = ['photo1', 'photo1_id'];
        $scenarios['photo2'] = ['photo2', 'photo2_id'];
        $scenarios['photo3'] = ['photo3', 'photo3_id'];
        $scenarios['photo4'] = ['photo4', 'photo4_id'];
        $scenarios['photo5'] = ['photo5', 'photo5_id'];
        $scenarios['avatar'] = ['avatar', 'avatar_id'];
        $scenarios['premium'] = ['premium_status', 'premium_type', 'premium_start_date', 'subscription_type', 'transaction_id', 'subscription_id'];

        return $scenarios;
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'name' => 'Name',
            'last_name' => 'Last Name',
            'dob' => 'Date of birthday',
            'gender' => 'Gender',
            'rank' => 'Rank',
            'relation_status' => 'Relation Status',
            'tag_line' => 'Tag Line',
            'zip_code' => 'Zip Code',
            'city' => 'City',
            'region' => 'Region',
            'state' => 'State',
            'premium_status' => 'Premium Status',
            'premium_type' => 'Premium Type',
            'premium_start_date' => 'Premium Start Date',
            'premium_end_date' => 'Premium End Date',
            'work' => 'Work',
            'love' => 'Love',
        ];
    }

    public function is_full_filled()
    {
        return (
            (($this->gender !== NULL))
            || ($this->relation_status  !== NULL)
            || (!empty($this->tag_line))
            || (!empty($this->work))
            || (!empty($this->love))
        );
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, ['>=', 'status', self::STATUS_SING_UP_FROM_FACEBOOK]]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

 /*   public static function create($user, $attributes)
    {
        $user->setAttributes($attributes);
        $user->setPassword($attributes['password']);
        $user->generateAuthKey();
        if ($user->save()) {
            $auth = Yii::$app->authManager;
            $userRole = $auth->getRole('user');
            $auth->assign($userRole, $user->getId());
        }
        return $user;
    }
 */

    public static function getStatusName($status)
    {
        switch($status){
            case self::STATUS_ACTIVE: return 'Active'; break;
            case self::STATUS_DELETED: return 'Delete'; break;
        }
    }

    public static function countActive()
    {
        return User::find()->where(['status' => User::STATUS_ACTIVE])->count();
    }

    public static function setUserInfoInSession()
    {
        if(!Yii::$app->session->get('user_name'))
        {
            $userID = Yii::$app->user->getId();
            $model = User::findOne($userID);
            Yii::$app->session->set('user_name', $model->name.' '.$model->last_name);
        }
    }

    public function getDataProvider()
    {
        $query = self::find();
        $query->andWhere(["status" => User::STATUS_ACTIVE]);
        return new ActiveDataProvider([
              'query' => $query
        ]);
    }

    public function search($params=[])
    {
        $query = User::find();

        $this->load($params);

        $query->andFilterWhere([
                'id' => $this->id,
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'dob' => $this->dob,
                'gender' => $this->gender,
                'rank' => $this->rank,
                'relation_status' => $this->relation_status,
                'premium_status' => $this->premium_status,
                'premium_type' => $this->premium_type,
                'premium_start_date' => $this->premium_start_date,
                'premium_end_date' => $this->premium_end_date,
            ]);

        $query->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'tag_line', $this->tag_line])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'work', $this->work])
            ->andFilterWhere(['like', 'love', $this->love])
            ->andFilterWhere(['like', 'avatar', $this->avatar]);

        if(!empty($this->role))
        {
            $query->joinWith('roles');
            $query->andWhere(['auth_assignment.item_name' => $this->role]);
        }
        $query->andWhere(['status' => User::STATUS_ACTIVE]);
        $query->orderBy('rank, created_at');

        return $query;
    }

    public function searchDataProvider($params)
    {
        $query = $this->search($params);
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    public function getRoles()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }

    public function loadPhoto($attribute)
    {
        $image = UploadedFile::getInstance($this, $attribute);

        if (!empty($image)) {
            $uniqueName = Yii::$app->security->generateRandomString() . '.' . $image->getExtension();
            if ($image->saveAs(Yii::$app->basePath . Yii::$app->params['imageUploadDir'] . $uniqueName)) {

                if($this->{$attribute} != '')
                {
                    $this->removePhoto($this->{$attribute});
                    Photo::deleteAll(['image' => $this->{$attribute}]);
                }

                $this->{$attribute} = $uniqueName;

                $this->resizeImage($uniqueName);
                if($attribute !== 'avatar'){
                    $idField= $attribute.'_id';
                    $this->$idField =  Photo::saveImage(Yii::$app->user->getId(), $this->$attribute);
                }
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
        $result = curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        $this->resizeImage($uniqueName);
        $this->{$attribute} = $uniqueName;
    }
    private function resizeImage($uniqueName){
        Photo::rotateIos($uniqueName);
        foreach (Yii::$app->params['avatarSize'] as $size) {
            Image::thumbnail(Yii::$app->basePath . Yii::$app->params['imageUploadDir'] . $uniqueName, $size[0], $size[1], 'inset')
                ->save(Yii::$app->basePath . Yii::$app->params['imageUploadDir'] . $size[0] . 'x' . $size[1] . $uniqueName);
        }
        foreach (Yii::$app->params['avatarSizeSquare'] as $size) {
            Image::thumbnail(Yii::$app->basePath . Yii::$app->params['imageUploadDir'] . $uniqueName, $size[0], $size[1])
                ->save(Yii::$app->basePath . Yii::$app->params['imageUploadDir'] . $size[0] . 'x' . $size[1].'_square' . $uniqueName);
        }
    }

    public function removePhoto($uniqName)
    {
        $fileName = Yii::$app->basePath . Yii::$app->params['imageUploadDir'] . $uniqName;
        if(file_exists($fileName))
        {
            unlink($fileName);
        }

        foreach (Yii::$app->params['avatarSize'] as $size) {
            $fileName = Yii::$app->basePath . Yii::$app->params['imageUploadDir'] . $size[0] . 'x' . $size[1] . $uniqName;
            if(file_exists($fileName))
            {
                unlink($fileName);
            }
        }
    }

    public function getImage()
    {
        return $this->avatar;
    }

    public function setAdressByZipCode($zipcode)
    {
        if(!is_numeric($zipcode))
        {
            $this->addError('zip_code', 'Not valid zip code');
            return false;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ziptasticapi.com/{$zipcode}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = json_decode(curl_exec($ch));
        curl_close($ch);

        if(isset($result->error))
        {
            $this->addError('zip_code', $result->error);
            return false;
        }
        else {
            $this->city = $result->city;
            $this->state = $result->state;
            $this->zip_code = $zipcode;
            return true;
        }
    }
    public function register(){

    }

    // DOB validation, fucking

    private $dateTimeDob = null;

    public function undoConvertedDOB()
    {
        //fuck it
    }

    public function validateDob($attribute, $params)
    {

        $dob_arr  = explode('/', $this->dob);

        if (count($dob_arr) !== 3 or !checkdate($dob_arr[0], $dob_arr[1], $dob_arr[2])) {
            $this->addError($attribute, 'Enter Valid DOB  MM/DD/YYYY');
            return false;
        }

        $this->dateTimeDob = \DateTime::createFromFormat('m/d/Y', $this->dob);
        $interval = $this->dateTimeDob->diff(new \DateTime);
        if($interval->y < 18){
            $this->addError($attribute, 'Oops sorry! you are so young.');
            return false;

        }
        if($interval->y > 80){
            $this->addError($attribute, 'Enter Valid DOB  MM/DD/YYYY');
            return false;
        }
    }
    public function convertDOB()
    {
        //Fuck it
    }

}
