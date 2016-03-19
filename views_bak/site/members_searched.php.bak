<?php
use yii\jui\AutoComplete;
use yii\web\JsExpression;
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
<?php
$n = count($members);
?>
<section class="members members--featured">
<ul class="members__list">
    <?php
    if($n>1)
    {
        $size = ($n>8)? 8 : $n;
    }
    else {
        $size = 0;
    }
        for($i=0; $i<$size; $i++)
        {
            $m = $members[$i];
            ?>
            <li class="members__item">
                <a href="<?=Url::to(['site/member', 'id' => 'qt'.$m['id']]);?>">
                    <figure class="members__photo">
                        <img src="/upload/255x255_square<?=$m['avatar'];?>" alt="" width="255" height="255">
                    </figure>
							<span class="members__name">
								  <?=$m['name'];?>
							</span>
                </a>
            </li>
            <?php
        }
    ?>
</ul>
</section>
<section class="members pagination">
    <ul class="members__list">
        <?php
        //удаляем первые 8 шт
        array_splice($members, 0, $size);
        echo $this->render('_small_members_block', ['members' => $members]);
        ?>
    </ul>
</section>