<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<div class="form">
    <?php $form = ActiveForm::begin([
        'id' => 'join-form',
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>
	<div class="form__row">
	    <?= $form->field($model, 'password')->passwordInput(array('placeholder' => 'Password', 'required' => 'required'))->label(false); ?>
	</div>
	<div class="form__row">
	    <?php
	    echo $form->field($model, 'dob')->textInput(array('placeholder' => 'DATE OF BIRTHDAY', 'class' => '', 'required' => 'required'))->label(false); ?>
	</div>
	<div class="form__row">
	    <?= $form->field($model, 'zip_code')->textInput(array('placeholder' => 'Zip Code', 'required' => 'required'))->label(false); ?>
	</div>
	<div class="form__row">
		<div class="input__file-button">
			<div class="button">Upload from computer</div>
			<?= $form->field($model, 'avatar')->fileInput()->label(false); ?>
		</div>
	</div>
	<div class="form__row">
	    <div class="form-group">
	        <div class="col-lg-offset-1 col-lg-11">
	            <?= Html::submitButton('Next', ['class' => 'button', 'name' => 'login-button']) ?>
	        </div>
	    </div>
	</div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = <<<JS
new FormValidation($('#join-form'));
$('.date-picker-input').datepicker({
	changeMonth: true,
	changeYear: true,
	minDate: new Date(1900, 1 - 1, 1),
	maxDate: '-18y',
	yearRange: "-100:+0"

});

$(function() {
    $('.input__file-button input').on('change', function() {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(input).closest('.input__file-button').find('.button').text('Change');
                $(input).closest('.input__file-button').next().html('<img src="' + e.target.result + '">')
            };
            reader.readAsDataURL(input.files[0]);
        }
    });
});
JS;
$this->registerJs($js);
?>