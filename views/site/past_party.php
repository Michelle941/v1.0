<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<style>
    li.photos__item{height: 160px;width: 160px;}
    .photos__item.small{width:135px; height: 135px}
    .photos__item.x350{width:300px; height: 300px}
</style>
<section class="event">
    <div class="event__photo">
        <?php
        if(empty($party->flyer_top))
        {
            ?>
            <img src="/images/temp/past-party-banner-top.png"" alt="" width="1110" height="276">
            <?php
        }
        else {
        ?>
        <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$party->flyer_top;?>" alt="" width="1110" height="276">
        <?php } ?>
    </div>
    <div class="photos photos--profile photos--popup pagination">
        <div class="content-button">
            <?php
            if(Yii::$app->user->isGuest):?>
                <a href="#login" class="button fancybox">LogIn to upload photos to this page</a>
            <?php else :?>
                <a href="/site/upload-to-party/<?=$party->id?>" class="button fancybox-ajax">Upload photos to this page</a>
            <?php endif;?>
        </div>
        <ul class="photos__list">
            <?php $ids = []; if(count($party->photo)):?>
                <? foreach (array_reverse($party->photo) as $key => $photo): $ids[] = $photo->id; ?>
                    <li class="photos__item">
                        <a href="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>" class="modalButton" value="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>">
                            <img src="/upload/350x350_square<?=$photo->image;?>" alt="">
                        </a>
                    </li>
                <?php endforeach;?>
            <?php endif;?>

            <?php $photos = \app\models\Photo::getPartyNewPhotos($party->id, 6, 0, $ids); if(count($photos)):?>
                <? foreach ($photos as $key => $photo): $ids[] = $photo->id; ?>
                    <li class="photos__item x350">
                        <a href="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>" class="modalButton" value="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>">
                            <img src="/upload/350x350_square<?=$photo->image;?>" alt="" width="350">
                        </a>
                    </li>
                <?php endforeach;?>
            <?php endif;?>
            <?php $photos = \app\models\Photo::getPartyPhotos($party->id, 10000, 0, $ids); if(count($photos)):?>
                <? foreach ($photos as $key => $photo): ?>
                    <li class="photos__item x350">
                        <a href="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>" class="modalButton" value="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>">
                            <img src="/upload/350x350_square<?=$photo->image;?>" alt="" width="350">
                        </a>
                    </li>
                <?php endforeach;?>
            <?php endif;?>
        </ul>
        <?php  if(\app\models\Photo::countPartyPhotos($party->id, $ids) > 10000) :?>
            <a href="<?= Url::to(['/site/load-party-photo', 'id' => $party->id]).'/'.implode(',', $ids); ?>" class="button load-more">Load more photos</a>
        <?php endif;?>
    </div>
    <div class="event__photo">
        <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$party->message_banner;?>" alt="" width="1110" height="276">
    </div>
    <div class="members pagination">
        <ul class="members__list">
            <?php
            echo $this->render('_party2profile', ['profile' => $profile]);
            ?>
        </ul>
        <?php
        if(\app\models\Party2profile::countByParty($party->id) > 10000)
        {
        ?>
        <a href="<?=Url::to(['/site/load-party-profile', 'id' => $party->id]);?>" class="button load-more">Load more members</a>
        <?php } ?>
    </div>
</section>