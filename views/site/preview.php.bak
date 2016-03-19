<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<style>
    .form a{text-decoration:underline !important;}
</style>
<div class="popup" style="width: 330px;">
    <div class="form">
        <h2 class="popup__title">
            HIDE YO’ WIFE<br>
            HIDE YO’ KIDS<br>
            YOU LOOK GOOD!
        </h2>

        <img src="/upload/255x255_square<?=$model->avatar;?>" width="255" height="255">

        <?php $form = ActiveForm::begin([
            'id' => 'join-step3-form',
            'action' => Url::to('/site/complete-join')
        ]);
        echo $form->field($model, 'id')->hiddenInput()->label(false);
        ?>
	    <div class="form__row">
            <p>
                Don't like your photo?<br>
                Don't worry bae, you can update<br>
                your photo from your dashboard
            </p>
	    </div>
        <div class="form__row">
            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton('JOIN', ['class' => 'button', 'name' => 'login-button', 'id' => 'join-step3-Button']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

        <footer class="popup__footer">
            <p>
                BY JOINING YOU AGREE TO OUR <a href="<?php Url::to('/page/terms');?>" target="_blank">TERMS OF USE</a>
            </p>
        </footer>
    </div>
</div>