<?php
use yii\helpers\Url;
use yii\helpers\Html;

$isMobile = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile');
?>

<section id="party-search">

        <div class="margins-80">

                <div class="party-search-bar">
			<form action="">
			 <?= Html::input('text', 'search', @$_GET['search'], ['placeholder'=>"SEARCH PARTIES", 'id' => 'ddd']) ?>
                        <button type="submit">
                                <i class="fa fa-search fa-1x"></i>
                        </button>
                </div><!-- party search bar -->

        </div><!-- margins: party search -->

        <div class="clearfix"></div>

</section><!-- party search section -->


<?php
if(isset($homepage)){
$homepage = 1;
}else{
$homepage = 0;
}
$odd_even = 0;
$upcoming_first = 0;
$past_first = 0;
$past_only = 0;
$stinger = 0;

foreach ($parties as $party) {
    if(strtotime($party->started_at) > time()){
        echo $this->render('_upcomingPartyOnMainPage', ['party' => $party, 'odd_even' => $odd_even, 'upcoming_first' => $upcoming_first, 'homepage' => $homepage, 'past_only' => $past_only, 'stinger'=>$stinger]);
	$upcoming_first++;
    }
    else{
	echo $this->render($isMobile ? 'mobile/_pastPartyOnMainPage' : '_pastPartyOnMainPage', ['party' => $party, 'odd_even' => $odd_even, 'past_first' => $past_first, 'homepage' => $homepage, 'past_only' => $past_only, 'stinger'=>$stinger]);
    	$past_first++;
    }
    $odd_even++;
}
?>




