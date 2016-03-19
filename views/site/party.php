<?php

use yii\helpers\Url;

$img_map1 = '';
$img_map2 = '';
if($_SERVER['REQUEST_URI'] == '/party/MrMarina'){
$img_map1 = 'usemap="#contestants1"';
$img_map2 = 'usemap="#contestants2"';
}
//check if it is an upcoming or past party
?>
<section id="party-single-banners">
<map name="contestants1">

    <div class="margins-80">
        <?php if (empty($party->sale->flyer_top)): ?>
            <img src="/images/temp/regular-sale-banner-top.png" alt="" width="1110" style="box-shadow: none;" <?php echo $img_map1;?>>
        <?php else : ?>
            <img src="<?= Yii::$app->params['flayerPath']; ?>/<?= $party->sale->flyer_top; ?>" alt="" width="1110" style="box-shadow: none;" <?php echo $img_map1;?>>
        <?php endif; ?>
	<map name="contestants1">
    <area shape="rect" coords="583,668,1097,768" href="/member/qt91" title="John Stevick" alt="John Stevick" target="_blank" />
    <area shape="rect" coords="53, 670, 534, 769" href="/member/qt105" title="Bradley Thomasma" alt="Bradley Thomasma" target="_blank" />
    <area shape="rect" coords="50, 804, 533, 896" href="/member/qt92" title="Drew Carter" alt="Drew Carter" target="_blank" />
    <area shape="rect" coords="583, 800, 1093, 901" href="https://www.tilt.com/tilts/mr-marina-fundraiser-korey-warzala" title="Korey Warzala" alt="Korey Warzala" target="_blank" />
    <area shape="rect" coords="51, 920, 539, 1021" href="https://www.tilt.com/tilts/mr-marina-fundraiser-edmo-gamelin" title="Edo Gamelin" alt="Edo Gamelin" target="_blank"/>
    <area shape="rect" coords="584, 921, 1092, 1019" href="https://www.tilt.com/tilts/mr-marina-fundraiser-mark-vallee" title="Mark Vallee" alt="Mark Vallee" target="_blank"/>
    <area shape="rect" coords="50, 1039, 544, 1140" href="https://www.tilt.com/tilts/mr-marina-fundraiser-garrett-ruhland" title="Garret Ruhland" alt="Garret Ruhland" target="_blank"/>
    <area shape="rect" coords="581, 1034, 1092, 1136" href="https://www.tilt.com/tilts/mr-marina-fundraiser-michael-becerra" title="Michael Becerra" alt="Michael Becerra" target="_blank"/>
    <area shape="rect" coords="48, 1152, 548, 1252" href="/member/qt96" title="Jake Radochonski" alt="Jake Radochonski" target="_blank"/>
    <area shape="rect" coords="578, 1153, 1089, 1255" href="https://www.tilt.com/tilts/mr-marina-fundraiser-michael-ray" title="Michael Ray" alt="Michael Ray" target="_blank"/>
    <area shape="rect" coords="51, 1270, 549, 1364" href="https://www.tilt.com/tilts/mr-marina-fundraiser-james-smith" title="James Smith" alt="James Smith" target="_blank"/>
    <area shape="rect" coords="582, 1271, 1086, 1367" href="https://www.tilt.com/tilts/mr-marina-competition-sean-harris" title="Sean Harris" alt="Sean Harris" target="_blank"/>

	</map>
        <?php
        if (isset($party->sale)) {
            echo $this->render('_buyTicketForm', ['sale' => $party->sale, 'partyID' => $party->id, 'eventbrite' => $party->sale->eventbrite_html]);
        };
        ?>

        <?php if (empty($party->sale->flyer_bottom)): ?>
            <img src="/images/temp/regular-sale-banner-bottom.png" alt="" width="1110" <?php echo $img_map2;?>>
        <?php else: ?>
            <img src="<?= Yii::$app->params['flayerPath']; ?>/<?= $party->sale->flyer_bottom; ?>" alt="" width="1110" style="box-shadow: none;" <?php echo $img_map2;?>>
        <?php endif; ?>
	<map name="contestants2">
    <area shape="rect" coords="560, 1204, 639, 1809" href="https://www.tilt.com/tilts/mr-marina-fundraiser-john-stevick" title="John Stevick" alt="John Stevick" target="_blank"/>
    <area shape="rect" coords="116, 1191, 195, 1814" href="https://www.tilt.com/tilts/mr-marina-fundraiser-bradley-thomasma" title="Bradley Thomasma" alt="Bradley Thomasma" target="_blank"/>
    <area shape="rect" coords="196, 1190, 277, 1812" href="https://www.tilt.com/tilts/mr-marina-fundraiser-drew-carter" title="Drew Carter" alt="Drew Carter" target="_blank"/>
    <area shape="rect" coords="638, 1197, 711, 1809" href="https://www.tilt.com/tilts/mr-marina-fundraiser-korey-warzala" title="Korey Warzala" alt="Korey Warzala" target="_blank"/>
    <area shape="rect" coords="277, 1192, 351, 1810" href="https://www.tilt.com/tilts/mr-marina-fundraiser-edmo-gamelin" title="Edo Gamelin" alt="Edo Gamelin" target="_blank"/>
    <area shape="rect" coords="712, 1196, 781, 1808" href="https://www.tilt.com/tilts/mr-marina-fundraiser-mark-vallee" title="Mark Vallee" alt="Mark Vallee" target="_blank"/>
    <area shape="rect" coords="353, 1191, 419, 1809" href="https://www.tilt.com/tilts/mr-marina-fundraiser-garrett-ruhland" title="Garret Ruhland" alt="Garret Ruhland" target="_blank"/>
    <area shape="rect" coords="783, 1197, 863, 1804" href="https://www.tilt.com/tilts/mr-marina-fundraiser-michael-becerra" title="Michael Becerra" alt="Michael Becerra" target="_blank"/>
    <area shape="rect" coords="419, 1195, 486, 1811" href="https://www.tilt.com/tilts/mr-marina-fundraiser-jake-radochonski" title="Jake Radochonski" alt="Jake Radochonski" target="_blank"/>
    <area shape="rect" coords="865, 1198, 940, 1801" href="https://www.tilt.com/tilts/mr-marina-fundraiser-michael-ray" title="Michael Ray" alt="Michael Ray" target="_blank"/>
    <area shape="rect" coords="486, 1196, 559, 1809" href="https://www.tilt.com/tilts/mr-marina-fundraiser-james-smith" title="James Smith" alt="James Smith" target="_blank"/>
    <area shape="rect" coords="942, 1202, 1023, 1799" href="https://www.tilt.com/tilts/mr-marina-competition-sean-harris" title="Sean Harris" alt="Sean Harris" target="_blank"/>

	</map>
        <br>

        <?php
        if (isset($party->sale)) {
            echo $this->render('_buyTicketForm_bottom', ['sale' => $party->sale, 'partyID' => $party->id, 'eventbrite' => $party->sale->eventbrite_html]);
        };
        ?>
    </div><!-- margins: party single banners -->

</section><!-- party single banners section -->

<section id="party-single-avatars">
    <div class="margins-80">
        <?php if (!empty($profile)): ?>
            <div>
                <img src="<?= Yii::$app->params['flayerPath']; ?>/<?= $party->sale->message_banner; ?>" alt="" width="1110" style="box-shadow: none;">
                <br>
            </div>

            <?php
            if (isset($profile)) {
                $total_profiles = 0;
                foreach ($profile as $p) {
                    $total_profiles++;
                }

                $i = 1;
                foreach ($profile as $p) {
                    if ($i == 21)
                        break;
                    $m = $p->user;
                    if ($m->org_user == 1) {
                        continue;
                    }
                    ?>

                    <div class="party-single-avatars-big-cell">
                        <a href="/member/qt<?php echo $m->id; ?>" class="noline">
                            <div class="party-single-avatars-big-circle">
                                <img src="/upload/160x160_square<?= $m->avatar; ?>" alt="" width="160" height="160" class="party-single-avatars-big-circle">
                                &nbsp;
                            </div><!-- party single avatars big circle -->
                        </a>
                    </div><!-- party single avatars big cell -->
                    <?php
                    if ($i > 0 && $i == $total_profiles) {
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
            <?php } ?>
        <?php endif; ?>
    </div>
</section><!-- party single avatars section -->
