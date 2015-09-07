<?php

foreach($photos as $photo)
{   ?>
    <li class="photos__item">
        <a class="fancybox-ajax" href="<?=\yii\helpers\Url::to(['/site/photo', 'id' => $photo->id]);?>">
            <img src="/upload/350x350_square<?=$photo->image;?>" alt="" width="540" height="540">
        </a>
    </li>
    <?php
}
?>