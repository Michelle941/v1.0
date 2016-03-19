<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\password\PasswordInput;
?>

<section id = "reset-password">
<div class="form">
    <div>
        <?php $form = ActiveForm::begin([
            'id' => 'join-form',
        ]); ?>
        New password:
        <?= $form->field($model, 'password')->widget(PasswordInput::classname(), [
            'pluginOptions' => [
                'showMeter' => true,
                'toggleMask' => true
            ]
        ]); ?>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Next', ['class' => 'button', 'name' => 'login-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
    <footer class="popup__footer">
        <p>

        </p>
    </footer>
</section>
</div>
<script>
// get the form id and set the event
$('#join-form :submit').on('click', function(e){
e.preventDefault();
submitFormMoreTime($(this.form));
});
</script>
