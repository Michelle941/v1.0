<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>

<div class="join-form-2">
    <div class="form">
        <h2 class="popup__title">
            JOIN THE CLUB
        </h2>
        <?php
        $form = ActiveForm::begin([
                    'id' => 'join-step2-form',
                    'options' => ['enctype' => 'multipart/form-data'],
                    'action' => Url::to('/site/join-step2'),
                    'fieldConfig' => [
                        'template' => '{input}{error}'
                    ],
        ]);
        ?>
        <?= $form->field($model, 'id')->hiddenInput(); ?>

        <div class="form__row">
            <?php
            echo $form->field($model, 'dob')->textInput(array(
                'class' => 'form-control date-picker-input',
                'placeholder' => 'DOB: mm/dd/yyyy',
                'required' => 'required',
                'type' => 'date',
            ))->label(false);
            ?>
        </div>

        <div class="form__row">
            <?php
            echo $form->field($model, 'zip_code')->textInput(array(
                'class' => 'form-control',
                'placeholder' => 'zip code',
                'required' => 'required'
            ))->label(false);
            ?>
        </div>

        <figure class="form__row user-image">
            <p style="font-size: 18px">Show off your cute face!</p>
            <p style="font-size: 14px">Upload a main profile photo</p>
        </figure>

        <div class="form__row">
        </div>

        <div class="buttons">
            <label class="custom-file-input button">
                <?php echo $form->field($model, 'avatar')->fileInput(array('style' => 'display:none;'))->label(false); ?>
                Upload from device
            </label>
            <!--<button type="button" class="button" id="instagram_image">Upload from Instagram</button>-->
            <button type="submit" class="button">Save</button>
        </div>

    </div>
    <?php ActiveForm::end(); ?>
</div>
<script>
    jQuery(function ($) {
        $('#join-step2-form').find('.custom-file-input input').on('change', function () {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#join-step2-form').find('.user-image').html('<img src="' + e.target.result + '" height="95" width="95">');
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
</script>
