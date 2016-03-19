<?php

foreach($parties as $party2user)
{
    ?>
    <li class="photos__item">
        <a href="<?=\yii\helpers\Url::to(['/site/party', 'id' => $party2user->party->url]);?>">
            <?php
            $banners = \app\models\Party::getBanners($party2user->party_id);
            ?>
            <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$banners['thumbnail'];?>" alt="" width="540" height="540">
        </a>
    </li>
    <?php
}
?>