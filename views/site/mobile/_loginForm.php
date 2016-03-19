<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$model = Yii::$app->controller->loginForm;
?>
<div class="login">
    <h2 class="popup__title">LOG INTO THE CLUB</h2>
    <?php
    $form = ActiveForm::begin([
                'id' => 'login-form',
                'action' => Url::to(["site/login"]),
                'fieldConfig' => [
                    'template' => '{input}{error}'
                ],
    ]);
    ?>

    <div class="form__row">
        <div class="form-group field-loginform-username required">
            <?= $form->field($model, 'username')->input('email', array('placeholder' => 'Email', 'required' => 'required')) ?>
        </div>
    </div>

    <div class="form__row">
        <div class="form-group field-loginform-password required">
            <?= $form->field($model, 'password')->passwordInput(array('placeholder' => 'Password', 'required' => 'required')) ?>
            <p class="help-block help-block-error"></p>
        </div>
    </div>

    <div class="form__row buttons" style="margin-top: 15px;">
        <?= Html::submitButton('Log in', ['class' => 'button-follow', 'id' => 'loginButton']) ?>
    </div>

    <footer class="popup__footer">
        <p>
            Haven't joined the club yet? <a href="#join" class="fancybox">Get started</a>
        </p>
        <p>
            <a href="#forgot-password" class="fancybox">Forgot your password?</a>
        </p>
    </footer>
    <?php ActiveForm::end(); ?>
</div>