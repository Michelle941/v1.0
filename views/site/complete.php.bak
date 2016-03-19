<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<div class="popup">
    <div class="form">
        <h2 class="popup__title">
            JOIN THE CLUB
        </h2>
        <?php $form = ActiveForm::begin([
            'id' => 'join-step2-form',
            'options' => ['enctype'=>'multipart/form-data'],
            'action' => Url::to('/site/join-step2'),
            'fieldConfig' => [
	            'template' => '{input}{error}'
            ],
        ]); ?>
        <?= $form->field($model, 'id')->hiddenInput(); ?>

        <div class="form__row">
            <?= $form->field($model, 'dob')->textInput(array('placeholder' => 'DoB: mm/dd/yyyy', 'class' => '', 'required' => 'required'))->label(false); ?>
        </div>

        <div class="form__row">
            <?= $form->field($model, 'zip_code')->textInput(array('placeholder' => 'ZIP CODE', 'required' => 'required'))->label(false); ?>
        </div>

        <div class="form__row">
            <p style="font-size: 18px">Show off your cute face!</p>
            <p style="font-size: 14px">Upload a main profile photo</p>
        </div>
        <div class="form__row">
	        <div class="input__file-button">
		        <div class="button">Upload from computer</div>
		        <?= $form->field($model, 'avatar')->fileInput()->label(false); ?>
	        </div>
        </div>
        <div class="form__row">
            <a id="instagram_image" href="#" class="button instagram_image">UPLOAD FROM INSTAGRAM</a>
            <div class="image"></div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<script>
	jQuery(function() {
		$('.input__file-button input').on('change', function() {
			var input = this;
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$(input).closest('.input__file-button').find('.button').text('Uploading...');
					$(input).next('.input__file-image').html('<img src="' + e.target.result + '">')
				};
				reader.readAsDataURL(input.files[0]);
			}
		});
	});
</script>
<?php
$js = <<<JS
if( isMobile.any() ) {
	$('.input__file-button').find('.button').text('Upload from device');
}
$('.date-picker-input').datepicker({
	changeMonth: true,
	changeYear: true,
	minDate: new Date(1900, 1 - 1, 1),
	maxDate: '-18y',
	yearRange: "-100:+0"

});
var joinStep2Form = $('#join-step2-form');
new FormValidation(joinStep2Form);
joinStep2Form.ajaxForm(function(data) {
     $('#join').html(data);
});
$('#user-avatar').on('change', function(){
    joinStep2Form.ajaxSubmit(function(data) {
     $('#join').html(data);
    });
});
$('#instagram_image').on('click', function(){
    joinStep2Form.append('<input type="hidden" name="instagram" value="true">');
    var data = joinStep2Form.serializeArray() ;
    $.post( "/site/join-instagram",data, function( data ) {
      $('#join').html(data);
    });
});

JS;
$this->registerJs($js);
?>
