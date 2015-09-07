<?php
use yii\helpers\Url;
?>
<li class="parties__item">
    <a href="<?=Url::to(['site/party/', 'id' => $party->url]);?>">
        <figure class="parties__photo">
            <?php
            if(empty($party->mini_flyer))
            {
                ?>
                <img src="/images/mini-flyer.jpg" alt="" width="1110">
            <?php
            }
            else {
            ?>
            <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$party->mini_flyer;?>" alt="" width="1110">
            <?php } ?>
        </figure>
    </a>
    <div class="members">
        <ul class="members__list">
            <?php
            if(isset($party->photo) && count($party->photo) > 5)
            {
                foreach ($party->photo as $key => $photo) { if( $key> 5) break;
                    ?>
                    <li class="members__item">
                        <a href="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>" class="modalButton fancybox-ajax" value="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>">
                            <img width="135" src="/upload/160x160_square<?=$photo->image;?>" alt="">
                        </a>
                    </li>
                <?php
                }
            }
            ?>
    </div>
</li>