<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<div class="popup" style="width: 760px;">
    <div class="form">
        <h2 class="popup__title">
            Add photo
        </h2>
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
            <div class="input__file-button">
                <div class="button">Upload from computer</div>
                <?= $form->field($photo, 'image')->fileInput()->label(false); ?>
            </div>
        </div>
        <div class="form__row">
            <a href="/user/instagram-photos?type=party&key=<?=$party->id?>" class="button instagram_image fancybox-ajax ">UPLOAD FROM INSTAGRAM</a>
            <div class="image"></div>
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
                    $(input).closest('.input__file-button').find('.button').text('Uploading...');
                    $('#upload-to-party').ajaxSubmit(function(data) {
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
