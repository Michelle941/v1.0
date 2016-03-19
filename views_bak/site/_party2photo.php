<?php
use yii\helpers\Url;

if(isset($photos))
{
    foreach ($photos as $photo) {
        ?>
        <li class="photos__item small">
            <a href="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>" class="modalButton" value="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>">
                <img src="/upload/160x160_square<?=$photo->image;?>" alt="" width="150">
            </a>
        </li>
    <?php
    }
}
?>