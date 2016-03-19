<?php
use app\models\Config;

$shablon = Config::getValue('mainPage', 'registration_email');
$link = Yii::$app->params['domen'].\yii\helpers\Url::to(['/site/email', 'hash' => $model->password_reset_token]);
$shablon = preg_replace('/#link#/', $link, $shablon);
$shablon = preg_replace('/#username#/', $model->name.' '.$model->last_name, $shablon);

echo $shablon;
?>