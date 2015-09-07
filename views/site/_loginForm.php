<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$model = Yii::$app->controller->loginForm;
?>
<div class="popup">
    <div class="form">
        <h2 class="popup__title">Log into the club</h2>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'action' => Url::to(['site/index']),
            'fieldConfig' => [
                'template' => '{input}{error}'
            ],
        ]); ?>

        <div class="form__row">
        <?= $form->field($model, 'username')->input('email', array('placeholder' => 'Email', 'required' => 'required')) ?>
	    </div>
	    <div class="form__row">
        <?= $form->field($model, 'password')->passwordInput(array('placeholder' => 'Password', 'required' => 'required')) ?>
	    </div>
	    <div class="form__row">
            <?= Html::submitButton('Log in', ['class' => 'button', 'id' => 'loginButton']) ?>
        </div>
        <footer class="popup__footer">
            <p>
                HAVEN’T JOINED THE CLUB YET? <a href="#join" class="fancybox">GET STARTED</a>
            </p>
            <p>
                <a href="#forgot-password" class="fancybox">FORGOT YOUR PASSWORD?</a>
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