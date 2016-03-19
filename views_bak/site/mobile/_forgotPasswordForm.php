<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$model = Yii::$app->controller->loginForm;
?>
<div class="form">
    <h2 class="popup__title">Reset password</h2>
    <?php
    $form = ActiveForm::begin([
                'id' => 'resend-password-form',
                'action' => Url::to(['/site/reset-password']),
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => '{input}{error}'
                ],
    ]);
    ?>

    <div class="form__row">
        <?php
        echo Html::textInput('email', '', array(
            'class' => 'form-control',
            'placeholder' => 'Email',
            'required' => 'required',
            'style' => 'height:auto;text-align:start;',
        ));
        ?>
    </div>
    <div class="form__row">
        <?php echo Html::submitButton('Reset password', ['class' => 'button-follow']); ?>
    </div>
    <footer class="popup__footer">
        <p>
            Haven't joined the club yet? <a href="#join" class="fancybox">Get started</a>
        </p>
        <p>
            Already a member? <a href="#login" class="fancybox">Log in</a>
        </p>
    </footer>
    <?php ActiveForm::end(); ?>
</div>
