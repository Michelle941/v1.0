<?php
use yii\helpers\Url;
?>
<li class="parties__item">
<a href="<?=Url::to(['site/party/', 'id' => $party->url]);?>" class="noline">
<?php 
if ($odd_even % 2 == 0) {
  $dark_light = "party-light";
}else{
  $dark_light = "party-dark";
}
?>
<section id="party" class=<?php echo '"' .$dark_light. '"';?>>

<?php if($homepage == 0 || $stinger == 1){ ?>
<section id="party-share-stinger">

	<div class="margins-80">
<?php }?>

<?php
if ($upcoming_first == 0 && $homepage == 0 && $past_only == 0) {
  echo '<img src="images/party-share-stinger-experiences.png" />';
}else{
if ($homepage == 1 && $past_only == 0){
  echo '<img src="images/party-share-stinger-experiences.png" />';
}
}
?>

<?php if($homepage == 0 || $stinger == 1){ ?>
	</div><!-- margins: party share stinger -->

</section><!-- party share stinger -->
<?php }?>

	<div class="margins-80">

		<div class="party-hero">
	<?php
            if(empty($party->sale->mini_flyer))
            {
                ?>
                <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$party->mini_flyer;?>" alt="Party Information" width="1110">
		<?php
            }
            else {
                ?>
                <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$party->sale->mini_flyer;?>" alt="Party Information" width="1110">
                <?php
            }
            ?>

                        <div class="party-avatar-container">

<?php
$profile = $party->party2profile;
//print_r($profile);
if(isset($profile))
{
$total_avatars = 0;
    foreach ($profile as $p) {
	$m = $p->user;
	if($m->avatar){
	    $total_avatars++;
	}
    }

$profile_counter = 1;
    foreach ($profile as $p) {
        if ($total_avatars < 5 || $profile_counter > 5){ break;}
	if ($profile_counter == 1){
		?>
			 <div class="party-avatar-cell">
			 <a href="<?=Url::to(['site/party/', 'id' => $party->url]);?>" class="noline">
			 <?php
            if(empty($party->sale->mini_flyer))
            {   
                ?>
		<div class="party-avatar" style="background-image: url('<?=Yii::$app->params['flayerPath'];?>/<?=$party->party_first;?>');">
                <?php
            }
            else {
                ?>
		<div class="party-avatar" style="background-image: url('<?=Yii::$app->params['flayerPath'];?>/<?=$party->sale->party_first;?>');">
                <?php
            }
            ?>
                                                
                                        </div><!-- party avatar -->
        		</div><!-- party avatar cell -->
        		</a>
		<?php
	}

        $m = $p->user;
        ?>
        <div class="party-avatar-cell">
	<a href="<?=\yii\helpers\Url::to(['/site/member', 'id' => 'qt'.$m->id]);?>">
 	<div class="party-avatar" style="background-image: url('/upload/160x160_square<?=$m->avatar;?>');">
                                                
                                        </div><!-- party avatar -->
        </div><!-- party avatar cell -->
        </a>
<?php

	if ($profile_counter == $total_avatars || $profile_counter == 5){
                ?>
                         <div class="party-avatar-cell">
                         <a href="<?=Url::to(['site/party/', 'id' => $party->url]);?>" class="noline">
                         <?php
            if(empty($party->sale->mini_flyer))
            {                                   
                ?>
                <div class="party-avatar" style="background-image: url('<?=Yii::$app->params['flayerPath'];?>/<?=$party->party_last;?>');">
                <?php   
            }   
            else {
                ?>
                <div class="party-avatar" style="background-image: url('<?=Yii::$app->params['flayerPath'];?>/<?=$party->sale->party_last;?>');">
                <?php
            }
            ?>
                                                &nbsp;
                                        </div><!-- party avatar -->
                        </div><!-- party avatar cell -->
                        </a>
                <?php
        }

    	$profile_counter++;
	}
}else{
?>
				<div class="party-avatar-cell">
					<div class="party-avatar" style="background-image: url('');">
						&nbsp;
					</div><!-- party avatar -->
				</div><!-- party avatar cell -->

<?php
}
?>

                                <div class="clearfix"></div>

                        </div><!-- party avatar container -->

		</div><!-- party hero -->

	</div><!-- margins: party -->

</section><!-- party section -->
</a>
