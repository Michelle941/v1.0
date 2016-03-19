<?php
use app\models\Statistic;
?>
<div>
    <section class="profile-info">
        <figure class="profile-info__photo">
            <img src="/upload/255x255_square<?=$model->getImage();?>" alt="" width="255" height="255">
        </figure>
        <div class="profile-info__info">
            <h1 class="profile-info__name"><?=$model->name;?></h1>

            <div class="profile-info__info-meta">
                <ul>
                    <li><?=Statistic::countByType($model->id, Statistic::TYPE_PROFILE_VIEWS);?> PROFILE VIEWS</li>
                    <li><?=\app\models\Following::countFollowing($model->id);?> FOLLOWERS</li>
                </ul>
            </div>
        </div>
    </section>
    <section>
        <a href="/user/update" class="button">DON’T BE BASIC. UPDATE YOUR PROFILE</a>
    </section>
</div>
