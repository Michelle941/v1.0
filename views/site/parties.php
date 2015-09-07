<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="search">
    <div class="form">
        <form action="">
            <?= Html::input('text', 'search', @$_GET['search'], ['placeholder'=>"Search", 'id' => 'ddd']) ?>
        </form>
    </div>
</div>
<section class="parties pagination">
    <ul class="parties__list">
        <?php
        echo $this->render('_party_block', [
                'parties' => $parties
        ]);
        ?>
    </ul>
    <?php
    if(! $is_last){
    ?>
    <a href="<?=Url::to(['/site/load-more-party']);?>?search=<?= @$_GET['search']?>" class="button load-more">Load more</a>
    <?php } ?>
</section>