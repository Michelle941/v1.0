<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<style>
    .popup__footer a{text-decoration:underline !important;}
</style>
<section id = "join">
<div class="popup">
    <div class="margins-75">
        <h2 style="margin-bottom: 5px;">
            JOIN THE CLUB
        </h2>
	    <div class="form__row" style="font-family: 'Questrial';">
        (Or don't. Whatever)
	    </div>
        <?php $form = ActiveForm::begin([
            'id' => 'join-form',
			'fieldConfig' => [
                'template' => '{input}{error}'
			]
        ]); ?>
        <div class="form__row">
            <?= $form->field(Yii::$app->controller->newUserModel, 'name')->textInput(array('placeholder' => 'First name', 'required' => 'required'))->label(false); ?>
        </div>
        <div class="form__row">
            <?= $form->field(Yii::$app->controller->newUserModel, 'last_name')->textInput(array('placeholder' => 'Last name', 'required' => 'required'))->label(false); ?>
        </div>
        <div class="form__row">
            <?= $form->field(Yii::$app->controller->newUserModel, 'email')->input('email', array('placeholder' => 'Email', 'required' => 'required'))->label(false); ?>
        </div>
        <div class="form__row">
            <?= $form->field(Yii::$app->controller->newUserModel, 'password')->passwordInput(array('placeholder' => 'Password', 'required' => 'required'))->label(false); ?>
        </div>
        <div class="form__row">
            <?= $form->field(Yii::$app->controller->newUserModel, 'password_repeat')->passwordInput(array('placeholder' => 'Repeat password', 'required' => 'required'))->label(false); ?>
        </div>
        <div class="form__row">
	<br>
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton('Next', ['class' => 'button-follow', 'name' => 'login-button', 'id' => 'joinButton']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
</section>
        <footer class="popup__footer">
            <p><br>
                By joining you agree to our <a href="<?php echo Url::to('/page/terms');?>" target="_blank">Terms of Use</a><br>
                Already a member? <a href="#login" class="fancybox">Log In</a>
            </p>
        </footer>
    </div>
</div>
<?php
$js = <<<JS
var joinForm = $('#join-form').off('submit');
new FormValidation(joinForm);
joinForm.on('submit', function(e) {
	e.preventDefault();
	if($(this).valid()) {
		$.post("/site/join", joinForm.serialize(), function(data) {
			$('#join').html(data);
		});
	}
});
JS;
$this->registerJs($js);
?>
