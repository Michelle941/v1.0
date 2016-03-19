<?php
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\helpers\Html;

?>
<section id="members-search" style="background-image: url('../../images/bg-light.png');">
	<div class="margins-80" style="background-image: url('../../images/bg-light.png');">
<div class="members-search-bar" style="background-image: url('../../images/bg-light.png');">
        <form action="/search">
            <?= Html::input('text', 'search', @$_GET['search'], ['placeholder'=>"SEARCH MEMBERS", 'id' => 'ddd']) ?>
        <button type="submit">
                                <i class="fa fa-search fa-1x"></i>
        </button>
	</form>
    </div>
</div>
</search>

<?php
$n = count($members);
?>

<section id="members-small-avatars" style="background-image: url('../../images/bg-light.png');">

        <div class="margins-75" style="background-image: url('../../images/bg-light.png');">

                <div class="group" style="margin-left: 30px">

<?php

//check to see if $members is needed too in addition to $newmembers
$members_counter = 1;
foreach($members as $m) {
$members_small_card_margin = '';
if($members_counter % 3 == 1){
   $members_small_card_margin = '';
}else{
   $members_small_card_margin = 'members-small-card-margin';
}
    ?>
    <a href="<?= Url::to(['site/member', 'id' => 'qt'.$m['id']]); ?>" class="noline">
    <div class="members-small-card <?php echo $members_small_card_margin; ?> equalize" style="height: 150px;">
        <div class="members-small-card-snipe" style="background-image: url(' /upload/95x95_square<?= $m['avatar']; ?> ');">
                                &nbsp;
        </div><!-- members small card snipe -->
            <h1><?= $m['name']; ?></h1>
            <span>
            <?php
                if($m['tag_line']){
                  echo '" ';
                  if (strlen($m['tag_line']) > 42) {
                     echo $m['tag_line']; //substr($m['tag_line'], 0, 39) . '...';
                  }
                  else{
                     $padding =  str_pad($m['tag_line'], 42, " ");
                     echo $padding;
                  }
                  echo ' "';
                }else{
                     echo str_pad('', 48, "&nbsp;");
                }
            ?>

            </span>
    </div><!-- members small card -->
    </a>
<?php
$members_counter++;
}
?>

        </div><!-- margins: members small avatars -->

        <div class="clearfix"></div>

</section><!-- members small avatars section -->



