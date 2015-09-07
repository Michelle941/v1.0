<?php
use yii\helpers\Url;
?>
<li class="parties__item">
    <a href="<?=Url::to(['site/party/', 'id' => $party->url]);?>">
        <figure class="parties__photo">
            <?php
            if(empty($party->sale->mini_flyer))
            {
                ?>
                <img src="/images/mini-flyer.jpg" alt="" width="1110">
                <?php
            }
            else {
                ?>
                <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$party->sale->mini_flyer;?>" alt="" width="1110">
                <?php
            }
            ?>
        </figure>
    </a>
    <div class="members">
        <ul class="members__list">
            <?php
            echo $this->render('_party2profile', ['profile' => $party->party2profile]);
            ?>
        </ul>
    </div>
</li>