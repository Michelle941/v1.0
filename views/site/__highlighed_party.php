<?php

foreach($parties as $party)
{
    ?>
    <li class="photos__item">
        <a href="<?=\yii\helpers\Url::to(['/site/party', 'id' => $party->url]);?>">
            <?php
            $banners = \app\models\Party::getBanners($party->id);
            ?>
            <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$banners['thumbnail'];?>" alt="" width="540" height="540">
        </a>
    </li>
    <?php
}
?>