<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<section id="party-search" style="background-image: url('/images/bg-dark.png');">

        <div class="margins-80">

<?php 
if($past_only == 1){
$tagline_image = '/images/nav-tagline1.png';
$tagline_style = 'margin-bottom: 1.5%; width: 100%; height: auto;';
}
else{
$tagline_image = '/images/nav-tagline2.png';
$tagline_style = 'margin-bottom: 1.5%; width: 100%; height: auto;';
}
?>
		<div>
		<img src="<?php echo $tagline_image; ?>" style="<?php echo $tagline_style; ?>">
                </div>
	</div>

	<div class="margins-80">
        </div><!-- margins: party search -->

        <div class="clearfix"></div>

</section><!-- party search section -->


<?php
$odd_even = 0;
$upcoming_first = 0;
$past_first = 0;

foreach ($parties as $party) {
    if(strtotime($party->started_at) > time()){
        echo $this->render('_upcomingPartyOnMainPage', ['party' => $party, 'odd_even' => $odd_even, 'upcoming_first' => $upcoming_first, 'homepage' => $homepage, 'past_only'=>$past_only, 'stinger'=>$stinger]);
	$upcoming_first++;
    }
    else{
        echo $this->render('_pastPartyOnMainPage', ['party' => $party, 'odd_even' => $odd_even, 'past_first' => $past_first, 'homepage' => $homepage, 'past_only'=>$past_only, 'stinger'=>$stinger]);
    	$past_first++;
    }
    $odd_even++;
}
?>




