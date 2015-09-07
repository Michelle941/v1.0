<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\AdminAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="bg-black">
<?php $this->beginBody() ?>

<div class="form-box" id="login-box">

<div class="header">Sign In</div>
    <?php $form = ActiveForm::begin([
            'id' => 'login-form',
        ]); ?>
    <div class="body bg-gray">
        <div class="form-group">
            <?= $form->field($model, 'username') ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="form-group">
            <?= $form->field($model, 'rememberMe', [
                    'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                ])->checkbox() ?>
        </div>
    </div>
    <div class="footer">
        <?= Html::submitButton('Login', ['class' => 'btn bg-olive btn-block', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
