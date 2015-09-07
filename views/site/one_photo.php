<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="row">
    <div class="col-8">
        <h3><?=$photo->comment;?></h3>
        <img src="/upload/<?=$photo->image;?>" style="max-width: 700px;">
    </div>
    <div class="col-4">
        <?php
        if(!Yii::$app->user->isGuest){
            if(!\app\models\Likes::is_liked($photo->id))
            {
              ?>
                <a href="<?=Url::to(['/user/like', 'id' => $photo->id]);?>">Like</a>
              <?php
            }
            else {
                ?>
                You like this photo
            <?php
            }
        }
        ?>
        <br>
        <?=\app\models\Statistic::countByType($photo->id, \app\models\Statistic::TYPE_PHOTO_VIEWS);?> views
        <br>
        <?php
        if($photo->allow2sharing && (!Yii::$app->user->isGuest)) {
            if (\app\models\SharingPhoto::is_share($photo->id)) {
                ?>
                You shared this photo
                <?php
            } else {
                $form = ActiveForm::begin(
                    [
                        'action' => Url::to(['/user/share-photo/', 'id' => $photo->id])
                    ]
                );
                if ($photo->allow2comment) {
                    ?>
                    <div class="form-group">
                        <?= Html::textInput('comment', $photo->comment); ?>
                    </div>
                <?php
                }
                ?>
                <div class="form-group">
                    <?= Html::submitButton('Share photo', ['class' => 'button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            <?php
            }
        }
        ?>
    </div>
</div>
