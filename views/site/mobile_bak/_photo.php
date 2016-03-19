<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$hasComment = !empty($photo->comment);
$isGuest = Yii::$app->user->isGuest;
$isLiked = \app\models\Likes::is_liked($photo->id);
$isOwner = $photo->user->id === $userId;
$isShared = $isOwner || \app\models\SharingPhoto::haveShared($photo->id, $userId);
?>

<div class="photo-view" data-id="<?php echo $photo->id; ?>" data-party="<?php echo $photo->party_id; ?>">

    <figure class="photo">
        <img src="/upload/350x350<?php echo $photo->image; ?>" alt="" width="350" height="350">
        <div class="photo-statistic">
            <span><?php echo (int) $photo->view_count; ?> Views</span>
            <span><?php echo (int) \app\models\Likes::countLike($photo->id); ?> Likes</span>
        </div>
    </figure>

    <div class="uploaded-by photo-view_section">
        <figure class="user-image">
            <a href="/member/qt<?php echo $photo->user->id; ?>">
                <img src="/upload/95x95_square<?php echo $photo->user->avatar; ?>" alt="" width="95" height="95">
            </a>
            <div>
                Uploaded by <?php echo Html::encode($photo->user->name); ?>
            </div>
        </figure>
    </div>

    <?php if (isset($shares)): ?>
        <div class="shared-by photo-view_section">
            <?php foreach ($shares as $share): ?>
                <figure class="user-image">
                    <a href="/member/qt<?php echo $share->user->id; ?>">
                        <img src="/upload/95x95_square<?php echo $share->user->avatar; ?>" alt="" width="95" height="95">
                    </a>
                    <div>
                        Shared by <?php echo Html::encode($share->user->name); ?>
                    </div>
                </figure>
                <p>
                    "<?php echo Html::encode($share->comment); ?>"
                </p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($hasComment || $isOwner): ?>
        <div class="photo-comment photo-view_section">
            <?php if ($hasComment): ?>
                <p class="comment-text">"<?php echo Html::encode($photo->comment); ?>"</p>
            <?php endif; ?>
            <?php if ($isOwner): ?>
                <textarea maxlength="100" placeholder="Say something funny"><?php echo Html::encode($photo->comment); ?></textarea>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (!$isGuest && !$isShared): ?>
        <div class="photo-share photo-view_section" style="display:none;">
            <figure class="user-image">
                <a href="/member/qt<?php echo $userId; ?>">
                    <img src="/upload/95x95_square<?php echo $user->avatar; ?>" alt="" width="95" height="95">
                </a>
                <div>
                    Share by <?php echo Html::encode($user->name); ?>
                </div>
            </figure>
            <div class="photo-comment">
                <textarea maxlength="100" placeholder="Say something funny"></textarea>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($photo->party_id > 0): ?>
        <div class="photo-party photo-view_section">
            <figure class="photo-party-img">
                <?php $banners = \app\models\Party::getBanners($photo->party_id); ?>
                <a href="/party/<?php echo $photo->party->url ?>">
                    <img src="<?php echo Yii::$app->params['flayerPath']; ?>/<?php echo $banners['thumbnail']; ?>" alt="" width="95" height="95">
                </a>
            </figure>
            <div class="photo-party-album">
                <?php echo $photo->party->title; ?> Album
            </div>
        </div>
    <?php endif; ?>

    <div class="buttons photo-view_section">
        <?php if ($isGuest): ?>
            <!--<button type="button" class="button" data-modal="#join">Join the club</button>-->
            <a href="#join" class="button fancybox">Join the club</a>
        <?php else: ?>

            <?php if (filter_input(INPUT_GET, 'source') === 'profile'): ?>
                <?php if ($isOwner): ?>
                    <button type="button" class="button" data-action="save" style="display:none;">Save</button>
                <?php endif; ?>
                <?php if (!$isLiked): ?>
                    <button type="button" class="button" data-action="like" data-url="<?php echo Url::to(['/user/like', 'id' => $photo->id]); ?>">Like</button>
                <?php endif; ?>
                <?php if ($isShared): ?>
                    <button type="button" class="button" data-action="unshare">Delete</button>
                <?php endif; ?>
            <?php else: ?>
                <?php if ($isOwner): ?>
                    <button type="button" class="button" data-action="save" style="display:none;">Save</button>
                <?php endif; ?>
                <?php if (!$isLiked): ?>
                    <button type="button" class="button" data-action="like" data-url="<?php echo Url::to(['/user/like', 'id' => $photo->id]); ?>">Like</button>
                <?php endif; ?>
                <?php if (!$isShared): ?>
                    <button type="button" class="button" data-action="share">Share</button>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
