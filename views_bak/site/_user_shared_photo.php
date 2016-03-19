<?php

foreach($photos as $share)
{
    ?>
    <li class="photos__item">
        <a href="<?=\yii\helpers\Url::to(['/site/photo', 'id' => $share->photo->id]);?>">
            <img src="/upload/540x540_square<?=$share->photo->image;?>" alt="" width="540" height="540">
        </a>
    </li>
    <?php
}
?>