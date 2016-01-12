<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\HandBook;
use app\models\Statistic;
?>
<style>
    .photos__item.small{width:135px; height: 135px}
</style>
<div>
    <section class="profile-info">
        <figure class="profile-info__photo">
            <div class="photos__actions">
                <div class="photos__actions-inner">
                    <a href="/user/update-avatar/" class="fancybox-ajax">UPDATE</a>
                </div>
            </div>
            <img src="/upload/255x255_square<?=$model->avatar; ?>" alt="">
        </figure>
        <div class="profile-info__info">
            <h1 class="profile-info__name"><?=$model->name;?></h1>
            <h2 class="profile-info__tagline"><?=$model->tag_line;?></h2>
            <p class="profile-info__sum">
                <?php
                if(is_numeric($model->relation_status)){
                    echo HandBook::getRelation($model->relation_status).'<br>';
                }
                if(!empty($model->work)){
                    $work = explode('#', $model->work);
                    $work[1] = isset($work[1]) ? $work[1]: '';
                    if ($work[0] < 10) {
                        echo HandBook::getWorkHeader($work[0]) . ' ' . ((!empty($work[1])) ? $work[1] : '');
                    } else if ($work[0] == 10) {
                        echo (!empty($work[1]) && !empty($work[2]))? $work[1].' AT '.$work[2] : '';
                    } else echo((!empty($work[1])) ? $work[1] : '');
                }

                echo '<br>';

                if(!empty($model->love)){
                    echo 'LOVES '.implode(', ', explode('#$%', $model->love));
                }
                ?>
            </p>
            <div class="profile-info__info-meta">
                <ul>
                    <li><a href="#secret" class="fancybox"><?=Statistic::countByType($model->id, Statistic::TYPE_PROFILE_VIEWS);?> PROFILE VIEWS</a></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="photos photos--profile photos--popup">
        <ul class="photos__list">
            <?php
            if(!empty($model->photo5))
            {
                ?>
                <li class="photos__item">
                    <a href="<?=\yii\helpers\Url::to(['/site/photo', 'id' => $model->photo5_id]);?>">
                        <img src="/upload/255x255_square<?=$model->photo5;?>" alt="">
                    </a>
                </li><?php
            }
            for($i=1; $i<=4; $i++)
            {
                $photo = 'photo'.$i;
                $idField = 'photo'.$i.'_id';
                if(!empty($model->$photo))
                {
                    ?>
                    <li class="photos__item">
                    <a href="<?=\yii\helpers\Url::to(['/site/photo', 'id' => $model->$idField]);?>">
                        <img src="/upload/255x255_square<?=$model->$photo;?>" alt="">
                    </a>
                    </li><?php
                }
            }

            foreach($sharedPhotos as $share)
            {
                ?>
                <li class="photos__item small">
                    <a href="<?=\yii\helpers\Url::to(['/site/photo', 'id' => $share->photo->id]);?>">
                        <img src="/upload/160x160_square<?=$share->photo->image;?>" alt="" width="135">
                    </a>
                </li>
                <?php
            }
            ?>
            <?php foreach($photos as $photo):?>
            <li class="photos__item small">
                <a href="<?=\yii\helpers\Url::to(['/site/photo', 'id' => $photo->id]);?>">
                    <img src="/upload/160x160_square<?=$photo->image;?>" alt="" width="135">
                </a>
            </li>
            <?php endforeach?>
        </ul>
    </section>
    <section class="photos-info">
	    <div class="button">
		    Add photos to party albums to see more photos on your profile
	    </div>
    </section>
    <section class="photos pagination">
        <ul class="photos__list">
            <?php
            if($highlighed)
                echo $this->render('/site/__highlighed_party', ['parties' => $usersParty]);
            else echo $this->render('/site/_user_shared_party', ['parties' => $usersParty]);
            ?>
        </ul>
    </section>
</div>
