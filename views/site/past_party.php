<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<section id="party-single-banners-past">

	<div class="margins-80">
	<?php
        if(empty($party->flyer_top))
        {
            ?>
            <img src="/images/temp/past-party-banner-top.png" alt="Description of Event">
            <?php
        }
        else {
        ?>
        <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$party->flyer_top;?>" alt="Description of Event">
        <?php } ?>

	    <?php
            if(Yii::$app->user->isGuest):?>
                <button href="#join" class="button fancybox">Join the club <br><br> to upload photos to this page</a>
            <?php else :?>
                <button href="/site/upload-to-party/<?=$party->id?>" class="button fancybox-ajax">Upload photos to this page</a>
            <?php endif;?>

	</div><!-- margins: party single banners past -->

</section><!-- party single banners past section -->

<section id="party-single-photos-past" style="background-image: url('../../images/bg-light.png');">

	<div class="margins-80">

	    <?php //margin-left every 5 photos
		$photo_counter = 1; 
		$ids = []; if(count($party->photo)):?>
                <?php foreach (array_reverse($party->photo) as $key => $photo): $ids[] = $photo->id; 
			if($photo_counter % 5 == 1){
                                        $margin_left = 'margin-left: 0;';
                                }else{
                                        $margin_left = '';}
			?>
                        <a href="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>" class="noline modalButton fancybox-ajax" value="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>">
                            <div class="party-past-single-photo" style="background-image: url('/upload/350x350_square<?=$photo->image;?>'); <?php echo $margin_left ?>">
                        &nbsp;
			</div>
			</a>
                <?php $photo_counter++; endforeach;?>
            <?php endif;?>

	    <?php $photos = \app\models\Photo::getPartyNewPhotos($party->id, 6, 0, $ids); if(count($photos)):?>
                <?php foreach ($photos as $key => $photo): $ids[] = $photo->id; 
			if($photo_counter % 5 == 1){
                                        $margin_left = 'margin-left: 0;"';
                                }else{
                                        $margin_left = '';}
			?>
                        <a href="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>" class="noline modalButton fancybox-ajax" value="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>">
                            <div class="party-past-single-photo" style="background-image: url('/upload/350x350_square<?=$photo->image;?>'); <?php echo $margin_left ?>">
                        &nbsp;
			</div>
			</a>
                <?php $photo_counter++; endforeach;?>
            <?php endif;?>

	    <?php $photos = \app\models\Photo::getPartyPhotos($party->id, 10000, 0, $ids); if(count($photos)):?>
                <?php foreach ($photos as $key => $photo): 
			if($photo_counter % 5 == 1){
                                        $margin_left = 'margin-left: 0;"';
                                }else{
                                        $margin_left = '';}
                        ?>
                        <a href="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>" class="noline modalButton fancybox-ajax" value="<?=Url::to(['/site/photo', 'id' => $photo->id]);?>">
                            <div class="party-past-single-photo" style="background-image: url('/upload/350x350_square<?=$photo->image;?>'); <?php echo $margin_left ?>">
                        &nbsp;
			</div></a>
                <?php $photo_counter++; endforeach;?>
            <?php endif;?>


	</div><!-- margins: party single photos past -->

	<div class="clearfix"></div>

</section><!-- party single photos past section -->

<section id="party-single-avatars">

        <div class="margins-80">

           <?php if(!empty($profile)):?>
            <div>
                <img src="<?= Yii::$app->params['flayerPath']; ?>/<?= $party->message_banner; ?>" alt="" width="1110" style="box-shadow: none;">
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
                        if($i==21000) break;
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

                        $i++;
                }
            ?>

        <div class="clearfix"></div>

</section><!-- party single avatars section -->
<?php } endif;?>
<?php
?>

