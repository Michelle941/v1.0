<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<div class="popup">
    <div class="form">
        <h2 class="popup__title">
            Fake
        </h2>
        <?php $form = ActiveForm::begin([
            'id' => 'fake-form',
            'options' => ['enctype'=>'multipart/form-data'],
            'action' => Url::to('/site/fake'),
            'fieldConfig' => [
                'template' => '{input}{error}'
            ],
        ]); ?>
        <div class="form__row">
            <div class="input__file-button-fake">
                <div class="button">Upload from computer</div>
                <?= Html::fileInput('image') ?>
            </div>
        </div>
        <div class="form__row">
            <a href="#" class="button instagram_image">UPLOAD FROM INSTAGRAM</a>
            <div class="image"></div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$js = <<<JS

jQuery(function() {
        $('.input__file-button-fake input').on('change', function() {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(input).closest('.input__file-button').find('.button').text('Uploading...');
                    $('#fake-form').ajaxSubmit(function(data) {
                      $('.fancybox-inner').html(data);
                    });
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    });

if( isMobile.any() ) {
	$('.input__file-button').find('.button').text('Upload from device');
}
JS;
$this->registerJs($js);
?>
