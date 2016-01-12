<?php
use yii\helpers\Url;
//check if it is an upcoming or past party
?>
<section id="party-single-banners">

	<div class="margins-80">

	<?php if(empty($party->sale->flyer_top)): ?>
                <img src="/images/temp/regular-sale-banner-top.png" alt="" width="1110" style="box-shadow: none;">
            <?php  else :?>
                <img src="<?= Yii::$app->params['flayerPath']; ?>/<?= $party->sale->flyer_top; ?>" alt="" width="1110" style="box-shadow: none;">
            <?php endif; ?>
	
	<?php
        if (isset($party->sale)) {
            echo $this->render('_buyTicketForm', ['sale' => $party->sale, 'partyID' => $party->id, 'eventbrite' => $party->sale->eventbrite_html]);
        };?>

	 <?php if(empty($party->sale->flyer_bottom)): ?>
            <img src="/images/temp/regular-sale-banner-bottom.png" alt="" width="1110">
            <?php else:?>
            <img src="<?= Yii::$app->params['flayerPath']; ?>/<?= $party->sale->flyer_bottom; ?>" alt="" width="1110" style="box-shadow: none;">
            <?php endif; ?>
            <br>
            
	<?php if (isset($party->sale)) {
                echo $this->render('_buyTicketForm_bottom', ['sale' => $party->sale, 'partyID' => $party->id, 'eventbrite' => $party->sale->eventbrite_html]);
            };?>

	</div><!-- margins: party single banners -->

</section><!-- party single banners section -->

<section id="party-single-avatars">

	<div class="margins-80">

           <?php if(!empty($profile)):?>
            <div>
                <img src="<?= Yii::$app->params['flayerPath']; ?>/<?= $party->sale->message_banner; ?>" alt="" width="1110" style="box-shadow: none;">
                <br>
            </div>

	   <?php 
		if(isset($profile))
		{
			$total_profiles=0;
			foreach ($profile as $p) {
			    $total_profiles++;
			}
			
			$i=1;
    			foreach ($profile as $p) {
			if($i==21) break;
        		$m = $p->user;
			if($m->org_user == 1) { continue;}
	   ?>

		        <div class="party-single-avatars-big-cell">
                        <a href="/member/qt<?php echo $m->id; ?>" class="noline">
                        <div class="party-single-avatars-big-circle">
                        <img src="/upload/160x160_square<?=$m->avatar;?>" alt="" width="160" height="160" class="party-single-avatars-big-circle">
			        &nbsp;
                        </div><!-- party single avatars big circle -->
                        </a>
                	</div><!-- party single avatars big cell -->
	    <?php
			if($i>0 && $i==$total_profiles){
			?>
			<div class="party-single-avatars-big-cell">
                        <div class="party-single-avatars-big-circle">
                        <img src="<?= Yii::$app->params['flayerPath']; ?>/<?= $party->sale->party_more; ?>" alt="" width="160" height="160" class="party-single-avatars-big-circle">
                                &nbsp;
                        </div><!-- party single avatars big circle -->
                        </a>
                        </div><!-- party single avatars big cell -->
		
	    <?php
			}



			$i++;
		}
	    ?>
	<div class="clearfix"></div>

</section><!-- party single avatars section -->
<?php } endif;?>
<?php
?>
