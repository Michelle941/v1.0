<?php
if(isset($profile))
{
    foreach ($profile as $p) {
        $m = $p->user;
        ?>
        <li class="members__item">
            <a href="<?=\yii\helpers\Url::to(['/site/member', 'id' => 'qt'.$m->id]);?>">
                <figure class="members__photo">
                    <img src="/upload/160x160_square<?=$m->avatar;?>" alt="" width="160" height="160">
                </figure>
            </a>
        </li>
    <?php
    }
}
?>