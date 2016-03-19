<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\helpers\HandBook;
use app\models\Statistic;
?>
<?php
// no longer have to be other user to view external self profile
if (Yii::$app->user->getId()) {

}
?>
<section id="profile-info">

    <div class="margins-80">

        <div class="group">
            <div class="profile-left">

                <div class="profile-holdname">
                    &nbsp;
                </div><!-- profile holdname -->

                <div class="profile-top-stripe pts-top-left equalize">

                    <div class="profile-top-stripe-snipe">

                        <a href="" class="noline">
                            <div class="profile-top-stripe-avatar" style="background-image: url('/upload/255x255_square<?= $user->avatar; ?>');">
                                &nbsp;
                            </div><!-- profile top stripe avatar -->
                        </a>

                    </div><!-- profile top stripe snipe -->

                </div><!-- profile top stripe -->

            </div><!-- profile left -->

            <div class="profile-right">

                <div class="profile-holdname">

                    <h1>
                        <?= $user->name; ?>
                    </h1>

                </div><!-- profile holdname -->

                <div class="profile-top-stripe pts-top-right equalize">

                    <?= $user->tag_line; ?>

                </div><!-- profile top stripe -->

            </div><!-- profile right -->
        </div><!-- (equalize) -->

        <div class="group">
            <div class="profile-left-under pts-bottom-left equalize">

                <div class="profile-left-cell">

                    <?php if (is_null($user->org_user) && is_numeric($user->relation_status)) { ?>
                        <span>
                            <i class="fa fa-heart-o fa-1x"></i>
                        </span>

                        <span>
                            <?php
                            echo HandBook::getRelation($user->relation_status) . '<br>';
                        }
                        ?>
                    </span>

                </div><!-- profile left cell -->

                <?php if (!empty($user->work) && strlen($user->work) > 5) { ?>
                    <div class="profile-left-cell">

                        <span>
                            <i class="fa fa-suitcase fa-1x"></i>
                        </span>

                        <span>
                            <?php
                            $work = explode('#', $user->work);
                            $work[1] = isset($work[1]) ? $work[1] : '';
                            if ($work[0] < 10) {
                                echo empty($work[1]) ? '' : HandBook::getWorkHeader($work[0]) . ' ' . ((!empty($work[1])) ? $work[1] : '');
                            } else if ($work[0] == 10) {
                                echo (!empty($work[1]) && !empty($work[2])) ? $work[1] . ' at ' . $work[2] : '';
                            } else
                                echo((!empty($work[1])) ? $work[1] : '');
                            ?>
                        </span>

                    </div><!-- profile left cell -->
                <?php } ?>

                <?php if (!empty($user->love) && strlen($user->love) > 2) { ?>
                    <div class="profile-left-cell">

                        <span>
                            <i class="fa fa-heart fa-1x"></i>
                        </span>

                        <span>
                            <?php
                            echo implode(', ', explode('#$%', $user->love));
                            ?>
                        </span>

                    </div><!-- profile left cell -->
                <?php } ?>
                <div class="profile-left-cell">

                    <span>
                        <i class="fa fa-eye fa-1x"></i>
                    </span>

                    <span>
                        <a href="#secret" class="fancybox" style="text-decoration: none;"><?= Statistic::countByType($user->id, Statistic::TYPE_PROFILE_VIEWS); ?> profile views</a>
                    </span>

                </div><!-- profile left cell -->

            </div><!-- profile left under -->

            <div class="profile-right-under pts-bottom-right equalize modal-popups">

                <?php
                $i = 1;
                foreach ($highlightedPhoto as $photo): if (!empty($photo)):
                        if ($i % 3 == 1) {
                            $margin_left = "margin-left: 0;";
                        } else {
                            $margin_left = "";
                        }
                        ?>
                        <a class="fancybox-ajax" href="<?= \yii\helpers\Url::to(['/site/photo', 'id' => $photo->id, 'source' => 'profile']); ?>"><div class="profile-right-under-image" style="background-image: url('/upload/350x350_square<?= $photo->image; ?>'); <?php echo $margin_left ?>">
                                &nbsp;
                            </div><!-- profile right under image --></a>

                        <?php
                    endif;
                    $i++;
                endforeach;
                ?>


                <?php
                foreach ($photos as $photo) {
                    if ($i % 3 == 1) {
                        $margin_left = "margin-left: 0;";
                    } else {
                        $margin_left = "";
                    }
                    ?>
                    <a class="fancybox-ajax" href="<?= \yii\helpers\Url::to(['/site/photo', 'id' => $photo->id]); ?>"><div class="profile-right-under-image" style="background-image: url('/upload/350x350_square<?= $photo->image; ?>'); <?php echo $margin_left ?>")>
                            &nbsp;
                        </div><!-- profile right under image --></a>
                    <?php
                    $i++;
                }
                ?>
            </div><!-- profile right under -->
        </div><!-- (equalize) -->



    </div><!-- margins: profile info -->

    <div class="clearfix"></div>

</section><!-- profile info section -->

<section id="profile-parties">

    <div class="margins-80">

        <?php
        $j = 1;
        if ($highlightedParty == true):
            ?>
            <?php echo $this->render('/site/__highlighed_party', ['parties' => $highlightedParties, 'iterator' => $j]); ?>
        <?php else: ?>
            <?php echo $this->render('/site/_user_shared_party', ['parties' => $usersParty, 'iterator' => $j]); ?>
        <?php endif; ?>

    </div><!-- margins: profile parties -->

    <div class="clearfix"></div>

</section><!-- profile parties section -->

<script src="<?= Url::to(['js/jquery.equalize.min.js']); ?>"></script>
<script>$(function () {
        equalize()
    });
    window.onresize = function () {
        equalize()
    }</script>
