<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>
<div class="search">
    <div class="form">
        <form action="/search">
            <?= Html::input('text', 'search', @$_GET['search'], ['placeholder'=>"Search", 'id' => 'ddd']) ?>
        </form>
    </div>
</div>
<section class="members members--featured">
<ul class="members__list">
    <?php $popularMembers = array_reverse($popularMembers);?>
    <?php foreach($popularMembers as $m):?>
        <li class="members__item">
            <a href="<?=Url::to(['site/member', 'id' => 'qt'.$m['id']]);?>">
                <figure class="members__photo"><img src="/upload/255x255_square<?=$m['avatar'];?>" alt="" width="255" height="255"></figure>
                <span class="members__name"><?=$m['name'];?></span>
            </a>
        </li>
    <?php endforeach;?>
</ul>
</section>
<section class="members pagination">
    <ul class="members__list">
        <?php echo $this->render('_small_members_block', ['members' => $newMembers]); ?>
        <?php echo $this->render('_small_members_block', ['members' => $members]); ?>
    </ul>
    <?php if(! $is_last): ?>
        <a href="<?=Url::to(['/site/load-more-user']);?>" class="button load-more">Load more</a>
    <?php endif; ?>
</section>