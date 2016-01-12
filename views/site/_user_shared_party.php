<?php

foreach($parties as $party2user)
{
$margin_left = "";
if($iterator == 1 || $iterator % 4 == 1){
$margin_left = 'margin-left: 0;';
}

$banners = \app\models\Party::getBanners($party2user->party_id);
?>
	<a href="<?=\yii\helpers\Url::to(['/site/party', 'id' => $party2user->party->url]);?>" class="noline">
                <div class="profile-parties-attended" style="background-image: url('<?=Yii::$app->params['flayerPath'];?>/<?=$banners['thumbnail'];?>'); <?php echo $margin_left;?>">
                        &nbsp;
                </div><!-- profile parties attended -->
                </a>
    <?php
$iterator++;
}
?>
