<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$model = Yii::$app->controller->loginForm;
?>
<div class="popup">
    <div class="login">
        <h2 class="popup__title">LOG INTO THE CLUB</h2>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'action' => Url::to(['site/index']),
            'fieldConfig' => [
                'template' => '{input}{error}'
            ],
        ]); ?>

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

	<div class="form__row" style:"margin-top: 10px;">
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
        <?php
        $js = <<<JS
        var loginForm = $( "#login-form" ).off('submit');
        new FormValidation(loginForm);
loginForm.on('submit', function(e) {
	e.preventDefault();
	if($(this).valid()) {
		$.post("/site/login", loginForm.serialize(), function(data)
    {
         $('#login').html(data);
    });
	}
});
JS;
        $this->registerJs($js);
        ?>
    </div>
</div>
