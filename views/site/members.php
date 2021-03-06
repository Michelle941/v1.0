<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>
<section id="members-search">
	<div class="margins-80">
<div class="members-search-bar">
        <form action="/search">
            <?= Html::input('text', 'search', @$_GET['search'], ['placeholder'=>"SEARCH MEMBERS", 'id' => 'ddd']) ?>
            <button type="submit">
				<i class="fa fa-search fa-1x"></i>
            </button>
	</form>
</div><!-- members search bar -->
</div><!-- margins: members search -->

<div class="clearfix"></div>

	<div class="member-snipe-top">
		&nbsp;
	</div><!-- members search snipe -->
</section><!-- members search section -->

<section id="members-stinger">

	<div class="margins-80">

		<img src="images/members-stinger.png" />

	</div><!-- margins: members stinger -->

</section><!-- members stinger section -->

<section id="members-big-avatars">

	<div class="margins-80">

	<?php $popularMembers = array_reverse($popularMembers);?>
        <?php foreach($popularMembers as $m):?>
        <div class="members-big-avatars-cell">
		<a href="<?=Url::to(['site/member', 'id' => 'qt'.$m['id']]);?>" style="text-decoration: none;">
                <div class="members-big-avatars-avatar" style="background-image: url('/upload/255x255_square<?=$m['avatar'];?>');">
                <?php $isMobile = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Mobile'); if($isMobile==false): ?><br><br><h1><?=$m['name'];?></h1><?php endif; ?>
	    </div><!-- members big avatars avatar -->
            </a>
	    </div><!-- members big avatar cell -->
        <?php endforeach;?>
	</div><!-- margins-95 -->
	<div class="clearfix"></div>

</section><!-- members big avatars section -->


<section id="members-small-avatars">

	<div class="margins-75">

		<div class="group" style="margin-left: 30px">

<?php

//check to see if $members is needed too in addition to $newmembers
$members_counter = 1;
foreach($newMembers as $m) {
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
                  echo ''; 
		  if (strlen($m['tag_line']) > 42) {
		     echo $m['tag_line']; //substr($m['tag_line'], 0, 39) . '...';
		  }
		  else{
		     $padding =  str_pad($m['tag_line'], 42, " ");
		     echo $padding;
		  }
		  echo '';
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

