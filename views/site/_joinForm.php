<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<style>
    .popup__footer a{text-decoration:underline !important;}
</style>
<div class="popup">
    <div class="form">
        <h2 class="popup__title">
            JOIN THE CLUB
        </h2>
	    <div class="form__row">
        (OR DON'T. WHATEVER)
	    </div>
        <?php $form = ActiveForm::begin([
            'id' => 'join-form',
			'fieldConfig' => [
                'template' => '{input}{error}'
			]
        ]); ?>
        <div class="form__row">
            <?= $form->field(Yii::$app->controller->newUserModel, 'name')->textInput(array('placeholder' => 'First Name', 'required' => 'required'))->label(false); ?>
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
            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton('Next', ['class' => 'button', 'name' => 'login-button', 'id' => 'joinButton']) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

        <footer class="popup__footer">
            <p>
                BY JOINING YOU AGREE TO OUR <a href="<?php Url::to('/page/terms');?>" target="_blank">TERMS OF USE</a><br>
                ALREADY A MEMBER? <a href="#login" class="fancybox">LOG IN NOW</a>
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