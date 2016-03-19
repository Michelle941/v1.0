<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
?>
<section id="join">
<style>
    .form a{text-decoration:underline !important;}
</style>
<div class="popup">
    <div class="form">
        <h2 style="margin-bottom: 5px;">
            HIDE YO’ KIDS<br style="margin-bottom: 5px;">
            HIDE YO’ WIFE<br style="margin-bottom: 5px;">
            YOU LOOK GOOD!
        </h2>
	<br>
        <div class="members-big-avatars-avatar" style="background-image: url('/upload/255x255_square<?=$model->avatar;?>');">
	</div>

        <?php $form = ActiveForm::begin([
            'id' => 'join-step3-form',
            'action' => Url::to('/site/complete-join')
        ]);
        echo $form->field($model, 'id')->hiddenInput()->label(false);
        ?>
	    <div class="form__row" style="margin-bottom: 5px;">
            <p style="margin-top: 10px;">
                Don't like your photo?<br>
                Don't worry bae, you can update<br>
                your photo from your dashboard
            </p>
	    </div>
	<br>
        <div class="form__row">
            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton('JOIN', ['class' => 'button-follow', 'name' => 'login-button', 'id' => 'join-step3-Button']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

        <footer class="popup__footer" style="margin-top: 20px; width: 95%">
                By joining you agree to our <a href="<?php Url::to('/page/terms');?>" target="_blank">Terms of Use</a>
        </footer>
    </div>
</div>
</section>
