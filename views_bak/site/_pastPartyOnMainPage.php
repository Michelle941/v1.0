<?php
use yii\helpers\Url;
?>
<a href="<?=Url::to(['site/party/', 'id' => $party->url]);?>">
<?php
if ($odd_even % 2 == 0) {
  $dark_light = "party-light";
}else{
  $dark_light = "party-dark";
}
?>
<section id="party" class=<?php echo '"' .$dark_light. '"';?>>

<?php
if ($homepage == 0 || $stinger == 1){ ?>
<section id="party-share-stinger">

	<div class="margins-80">
<?php } ?>

<?php
if ($past_first == 0 && $homepage == 0 && $past_only == 0) {
  echo '<img src="images/party-share-stinger-photos.png" />';
}else{
if($homepage == 1 && $past_only == 0){
  echo '<img src="images/party-share-stinger-photos.png" />';
}
}
?>

<?php
if ($homepage == 0 || $stinger == 1){ ?>
	</div><!-- margins: party share stinger -->

</section><!-- party share stinger -->
<?php } ?>

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
            if(isset($party->photo)) //&& count($party->photo) > 5)
            {
		$total_party_photo = 0;
		foreach ($party->photo as $key => $photo){
			$total_party_photo++;
		}

		$party_photo_counter = 1;
                foreach ($party->photo as $key => $photo) { 
		    if( $total_party_photo < 4 || $party_photo_counter> 5 ) break;
                    if($key==0){
			?>
			<div class="party-avatar-cell">
                    	<a href="<?=Url::to(['site/party/', 'id' => $party->url]);?>">
			<?php
            if(empty($party->sale->mini_flyer))
            {
                ?>
		<div class="share-avatar" style="background-image: url('<?=Yii::$app->params['flayerPath'];?>/<?=$party->party_first;?>');">
                <?php
            }
            else {
                ?>
		<div class="share-avatar" style="background-image: url('<?=Yii::$app->params['flayerPath'];?>/<?=$party->sale->party_first;?>');">
                <?php
            }
            ?>
                    
                    </div><!-- party avatar -->
                    </div><!-- party avatar cell -->

			<?php
		    }//end if key == 0

		    ?>
		    <div class="party-avatar-cell">
		    <a href="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>" class="modalButton fancybox-ajax" value="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>">
                    <div class="share-avatar noline" style="background-image: url('/upload/160x160_square<?=$photo->image;?>');">
                    
                    </div><!-- party avatar -->
                    </div><!-- party avatar cell -->
                    </a>
                <?php

			if($key==$total_party_photo-1 || $key>3){
			?>
                        <div class="party-avatar-cell">
                        <a href="<?=Url::to(['site/party/', 'id' => $party->url]);?>">
                        <?php	
			if(empty($party->sale->mini_flyer))
            {
                ?>
                <div class="share-avatar noline" style="background-image: url('<?=Yii::$app->params['flayerPath'];?>/<?=$party->party_last;?>');">
                <?php
            }
            else {
                ?>
                <div class="share-avatar noline" style="background-image: url('<?=Yii::$app->params['flayerPath'];?>/<?=$party->sale->party_last;?>');">
                <?php
            }
            ?>
                    
                    </div><!-- party avatar -->
                    </div><!-- party avatar cell -->
                        <?php
			}
		$party_photo_counter++;
		}//end foreach loop
            }else{?>

<?php
}
?>
		<div class="clearfix"></div>
		</div><!-- party avatar container -->

		</div><!-- party hero -->

	</div><!-- margins: party -->

</section><!-- party section -->
</a>
