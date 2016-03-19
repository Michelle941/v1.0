<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<?php
$isMobile = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Mobile');
if($isMobile==true){
$style='width: 350px; height: auto;';
}else{
$style= 'width: 610px;';
}
?>
<section id="single-photo">
<div id="uploader" class="popup" style="<?php echo $style; ?>;">
    <div class="form">
        <h2 class="popup__title">
            ADD PHOTO
        </h2>
	<br>
        <?php $form = ActiveForm::begin([
            'id' => 'upload-to-party',
            'options' => ['enctype'=>'multipart/form-data'],
            'action' => Url::to('/site/upload-to-party/'.$party->id),
            'fieldConfig' => [
                'template' => '{input}{error}'
            ],
        ]); ?>
        <?= $form->field($party, 'id')->hiddenInput(); ?>
        <?= $form->field($photo, 'party_id')->hiddenInput(); ?>

        <div class="form__row">
            <div class="input__file-button" style="noline">
                <label class="custom-file-input" style="width: 245px;">
                <?= $form->field($photo, 'image')->fileInput(array('style'=>'display: none'))->label(false); ?>
		<br>&nbsp;</label>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$js = <<<JS

jQuery(function() {
        $('.input__file-button input').on('change', function() {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#upload-to-party').ajaxSubmit(function(data) {
                      $('.fancybox-skin').html(data);
                    });
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
JS;
$this->registerJs($js);
?>
</section>
