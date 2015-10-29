<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\helpers\HandBook;
use app\models\Statistic;

?>
<style>
    .profile-info__info{width:520px !important;}
    hr.thin {
        height: 1px;
        border: 0;
        color: #333;
        background-color: #333;
        width: 100%;
        margin-bottom: 30px;
    }

</style>
<div>
    <section class="profile-info">
        <?php if(Yii::$app->user->getId() == $user->id):?>
            <figure class="profile-info__photo">
                <div class="photos__actions">
                    <div class="photos__actions-inner">
                        <a href="/user/update-avatar/" class="fancybox-ajax">UPDATE</a>
                    </div>
                </div>
                <img src="/upload/255x255_square<?=$user->avatar; ?>" alt="">
            </figure>
        <?php else:?>
        <figure class="profile-info__photo">
            <img src="/upload/255x255_square<?=$user->avatar;?>" alt="" width="255" height="255">
        </figure>
        <?php endif;?>
        <div class="profile-info__actions">
            <ul>
                <li class="profile-info__actions-item">
                    <div id="js-follow">
                    <?php if(Yii::$app->user->isGuest){
                       ?>
                        <a href="#login" class="fancybox button">Follow</a>
                       <?php
                    }
                    elseif(Yii::$app->user->getId() == $user->id)
                    {
                        //пусто в своем профиле
                    }
                    elseif(\app\models\Following::checkFollow($user->id)) {
                        ?>
                        <div class="button">Following</div>
                        <?php
                    }
                    else {
                    ?>
                        <a href="<?=Url::to(['/user/follow', 'id' => $user->id]);?>" class="js-follow-link button">Follow</a>
                    <?php };?>
                    </div>
                </li>
                <li class="profile-info__actions-item">
                    <?php if(Yii::$app->user->isGuest) {
                        ?>
                        <a href="#login" class="fancybox button">Message</a>
                    <?php
                    }
                    elseif(Yii::$app->user->getId() == $user->id)
                    {
                        //пусто в своем профиле
                    }
                    else {
                        ?>
                        <?= Html::a(
                            'Message',
		                    Url::to(['/user/send-mail', 'id' => $user->id]),
                            [
                                'class' => 'button fancybox fancybox.ajax'
                            ]) ?>
                    <?php
                    }
                    ?>
                </li>
            </ul>
        </div>
        <div class="profile-info__info">
            <h1 class="profile-info__name"><?=$user->name;?></h1>
            <?php
            if(!empty($user->tag_line)){
                ?>
                <h2 class="profile-info__tagline"><?=$user->tag_line;?></h2>
            <?php };?>
            <p class="profile-info__sum">
                <?php
                if(is_numeric($user->relation_status)){
                    echo HandBook::getRelation($user->relation_status).'<br>';
                }
                if(!empty($user->work)) {
                    $work = explode('#', $user->work);
                    $work[1] = isset($work[1]) ? $work[1]: '';
                    if ($work[0] < 10) {
                        echo empty($work[1]) ? '': HandBook::getWorkHeader($work[0]) . ' ' . ((!empty($work[1])) ? $work[1] : '');
                    } else if ($work[0] == 10) {
                        echo (!empty($work[1]) && !empty($work[2]))  ? $work[1] . ' AT ' . $work[2] : '';
                    } else echo((!empty($work[1])) ? $work[1] : '');
                }

                echo '<br>';
                if(!empty($user->love)){
                    echo 'LOVES '.implode(', ', explode('#$%', $user->love));
                }
                ?>
            </p>
            <div class="profile-info__info-meta">
                <ul>
                    <li><a href="#secret" class="fancybox"><?=Statistic::countByType($user->id, Statistic::TYPE_PROFILE_VIEWS);?> PROFILE VIEWS</a></li>
                    <li><a href="#secret" class="fancybox"><?=\app\models\Following::countFollowing($user->id);?> FOLLOWERS</a></li>
                </ul>
            </div>
        </div>
    </section>
    <section style="clear: both" class="photos photos--profile photos--popup">
        <ul class="photos__list">
            <?php foreach ($highlightedPhoto as $photo): if (!empty($photo)):?>
            <li class="photos__item">
                <a href="<?=\yii\helpers\Url::to(['/site/photo', 'id' => $photo->id]);?>">
                    <img src="/upload/350x350_square<?=$photo->image;?>" alt="" width="540" height="540">
                </a>
            </li>
            <?php endif;endforeach;?>
        </ul>
    </section>
    <section class="photos pagination">
        <ul class="photos__list">
            <?=$this->render('_photos', ['photos' => $photos]);?>
        </ul>
        <?php if($hasMorePhoto):?>
        <a href="<?=Url::to(['/site/load-user-photos', 'id' => $user->id, 'newPhotoId' => $newPhotoId]);?>" class="button load-more">Load more photos</a>
        <?php endif;?>
        <hr class="thin">
    </section>
    <?php if($highlightedParty == true): ?>
        <section class="photos-info">
            <div class="button">
                Add photos to party albums to see more photos on your profile
            </div>
        </section>
        <section class="photos pagination">
            <ul class="photos__list">
                <?php echo $this->render('/site/__highlighed_party', ['parties' => $highlightedParties]);?>
            </ul>
        </section>
    <?php else:?>
        <section class="photos pagination">
            <ul class="photos__list">
                <?php echo $this->render('/site/_user_shared_party', ['parties' => $usersParty]);?>
            </ul>
            <?php if($hasMoreParties):?>
                <a href="<?=Url::to(['/site/load-user-parties', 'id' => $user->id]);?>" class="button load-more">Load more parties</a>
            <?php endif;?>
        </section>
    <?php endif;?>
</div>