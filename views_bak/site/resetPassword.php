<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<section id = "reset-password-page">
<style>
    .popup__footer a{text-decoration:underline !important;}
</style>
<div class="popup">
    <div class="form"  style="width: 300px;margin: 0px auto; margin-top: 50px; margin-bottom: 50px;">
        <h2 class="popup__title">RESET PASSWORD</h2>
        <?php $form = ActiveForm::begin([
            'id' => 'set-password-form',
			'fieldConfig' => [
                'template' => '{input}{error}'
			]
        ]); ?>
         <div class="form__row">
            <?= $form->field($model, 'password')->passwordInput(array('placeholder' => 'Password', 'required' => 'required'))->label(false); ?>
        </div>
        <div class="form__row">
            <?= $form->field($model, 'password_repeat')->passwordInput(array('placeholder' => 'Repeat password', 'required' => 'required'))->label(false); ?>
        </div>
        <div class="form__row">
            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton('Save', ['class' => 'button-follow', 'name' => 'login-button', 'id' => 'joinButton']) ?>
                </div>
            </div>
        </div>
</section>
        <?php ActiveForm::end(); ?>
    </div>
</div>
