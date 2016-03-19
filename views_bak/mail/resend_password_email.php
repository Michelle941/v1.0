<?php
$link = Yii::$app->params['domen'].\yii\helpers\Url::to(['/site/set-password', 'hash' => $model->password_reset_token]);
$image = Yii::$app->params['domen'].\yii\helpers\Url::to(['/images/mess.jpg']);

?>
<div>
    <p>Hello <?php echo ucfirst($model->name)?>,</p><br>
    <p>Here is the dirty picture we promised.</p>
    <p><img width="300px" src="<?php echo $image?>"></p><br>
    <p>And here is the link to reset your password</p>
    <a href="<?php echo $link?>"><?php echo $link?></a>
</div>