<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="popup pages-form" style="margin: 0 auto">
    <div class="form row ">
        <h2 class="popup__title">Login to manage your party</h2>
        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'template' => '{input}{error}'
            ],
        ]); ?>

        <div class="form__row col-md-8 form-group field-party-title required">
            <?= Html::input( 'text', 'username', @$_POST['username'], array('placeholder' => 'Username', 'required' => 'required')) ?>
	    </div>
	    <div class="form__row col-md-8 form-group field-party-title required">
            <?= Html::input( 'password', 'password', '',array('placeholder' => 'Password', 'required' => 'required')) ?>
	    </div>
	    <div class="form__row col-md-8">
            <?= Html::submitButton('Log in', ['class' => 'button', 'id' => 'loginButton']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>