<?php
use yii\helpers\Url;
if(isset($party->sale)) {
    ?>
    <section class="event">
        <div class="event__photo">
            <?php if(empty($party->sale->flyer_top)): ?>
                <img src="/images/temp/regular-sale-banner-top.png" alt="" width="1110">
            <?php  else :?>
                <img src="<?= Yii::$app->params['flayerPath']; ?>/<?= $party->sale->flyer_top; ?>" alt="" width="1110">
            <?php endif; ?>
        </div>

        <?php if (isset($party->sale)) {
            echo $this->render('_buyTicketForm', ['sale' => $party->sale, 'partyID' => $party->id]);
        };?>

        <div class="event__photo">
            <?php if(empty($party->sale->flyer_bottom)): ?>
            <img src="/images/temp/regular-sale-banner-bottom.png" alt="" width="1110">
            <?php else:?>
            <img src="<?= Yii::$app->params['flayerPath']; ?>/<?= $party->sale->flyer_bottom; ?>" alt="" width="1110">
            <?php endif; ?>
            <br>
            <?php if (isset($party->sale)) {
                echo $this->render('_buyTicketForm', ['sale' => $party->sale, 'partyID' => $party->id]);
            };?>
        </div>

        <div class="members pagination">
            <ul class="members__list">
                <?php  echo $this->render('_party2profile', ['profile' => $profile]); ?>
            </ul>
            <?php if(\app\models\Party2profile::countByParty($party->id) > 8) :?>
            <a href="<?= Url::to(['/site/load-party-profile', 'id' => $party->id]); ?>" class="button load-more">SEE MORE MEMBERS WHO BOUGHT TICKETS</a>
            <?php endif; ?>
        </div>
    </section>
<?php
}
else {
    echo 'No sale :(';
}
?>