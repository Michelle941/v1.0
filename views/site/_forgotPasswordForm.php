<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$model = Yii::$app->controller->loginForm;
?>
<div class="popup">
    <div class="form">
        <h2 class="popup__title">Reset password</h2>
        <?php $form = ActiveForm::begin([
            'id' => 'resend-password-form',
            'action' => Url::to(['/site/reset-password']),
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
	            'template' => '{input}{error}'
            ],
        ]); ?>

	    <div class="form__row">
        <?=  Html::textInput('email', '',array('placeholder' => 'Email')) ?>
	    </div>
        <div class="form__row">
            <?= Html::submitButton('Reset password', ['class' => 'button', 'id' => 'resetPasswordButton']) ?>

        </div>
        <footer class="popup__footer">
            <p>
                HAVEN’T JOINED THE CLUB YET? <a href="#join" class="fancybox">GET STARTED</a>
            </p>
            <p>
                ALREADY A MEMBER? <a href="#login" class="fancybox">LOG IN NOW</a>
            </p>
        </footer>
        <?php ActiveForm::end(); ?>
        <?php
        $js = <<<JS
$('#resetPasswordButton').click(function(e)
{
    e.preventDefault();
    $.post("/site/reset-password", $( "#resend-password-form" ).serialize(), function(data)
    {
         $('#forgot-password').html(data);
    });
}
);
JS;
        $this->registerJs($js);
        ?>
    </div>
</div>