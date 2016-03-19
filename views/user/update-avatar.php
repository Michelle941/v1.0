<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<section id="join">
<div class="popup">
    <div class="form">
        <h2 class="popup__title">
            UPDATE PHOTO
        </h2>
        <?php $form = ActiveForm::begin([
            'id' => 'upload-avatar',
            'options' => ['enctype'=>'multipart/form-data'],
            'fieldConfig' => [
	            'template' => '{input}{error}'
            ],
        ]); ?>

<br><br>
 	<div class="form__row">
                        <div class="input__file-button">
                        <label class="custom-file-input" style="width: 245px;">
                        <?= $form->field($model, 'avatar')->fileInput(array('style'=>'display: none'))->label(false); ?>
                        <br>&nbsp;</label>
                        </div>
                </div>
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
					//$(input).closest('.input__file-button').find('.button').text('Uploading...');
                    $( "#upload-avatar" ).submit();
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
JS;
$this->registerJs($js);
?>
</section>
