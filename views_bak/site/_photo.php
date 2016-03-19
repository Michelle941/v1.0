<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php
$isMobile = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile');
$isMobile = false;
?>

<section id="single-photo">
    <style>
        .fancybox-inner{margin-left: 20px;}
        .fancybox-skin{background-image: none !important;}
        .fancybox-skin{padding: 0px 0px !important;}
        .photo-meta__content .photo-meta__title{margin-bottom: 5px;width: 275px;}
        .comment{margin: 0px; width: 277px; height: 70px;font-family: 'Questrial', sans-serif; }
        .comment textarea{font-size: inherit; font-family: 'Questrial', sans-serif; }
        .hide{display:none;}
        .photo-social{clear: both; margin-top: 15px;width: 100%;}
        .photo-social li{ display: inline;}
        .photo-social li:first-child{ float: left;}
        .photo-social li:last-child{ float: right;}
        /*a.fancybox-item.fancybox-close{display: none !important;}*/
        #photo-popup a.button-popup{height: 50px; margin: 15px 0px; position: relative}
    </style>
    <div  class="popup" style="height: 600px">
        <a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>
        <div id="photo-popup"  class="photo" style="width: <?php
        if ($isMobile == true) {
            echo '80px';
        } else {
            echo '800px';
        }
        ?>">
            <figure class="photo__img">
                <img src="/upload/350x350<?= $photo->image; ?>" alt="" width="350" height="350">
                <div class="photo-left-snipe">
                    <table class="table-blank"><tr><td>
                                <?= (int) $photo->view_count ?> Views &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <?= \app\models\Likes::countLike($photo->id); ?> Likes
                            </td></tr></table>
                </div><!-- small pic snipe -->
            </figure>
            <?php
            if ($isMobile == true) {
                echo '</div><br><br><br>';
                $photo_meta_style = 'style="margin-left: 120px;"';
                $photo_meta_align = 'style="margin-top: 10px; margin-left: 30px;" align=center';
                $button_align_join = 'margin-left: auto;';
                $button_align_close = 'margin-left: auto;';
                $button_padding_close = '114px';
                $mobile_button_margin = '';
                $mobile_button_delete_margin = '<br>';
            } else {
                $photo_meta_style = '';
                $photo_meta_align = '';
                $button_align_join = 'margin-left: 25%;';
                $button_align_close = 'margin-left: 2px;';
                $button_padding_close = '29%';
                $mobile_button_margin = 'margin-left: 25%;';
                $mobile_button_delete_margin = '';
            }
            ?>
            <div class="photo-meta">
                <ul class="photo-meta__list">
                    <li class="photo-meta__item">
                        <figure class="photo-meta__img" <?php echo $photo_meta_style; ?>>
                            <a href="/member/qt<?= $photo->user->id; ?>"><img src="/upload/95x95_square<?= $photo->user->avatar; ?>" alt="" width="95" height="95" style="border-radius: 50%;"></a>
                        </figure>
                        <div class="photo-meta__content" <?php echo $photo_meta_align; ?>>
                            Uploaded by <?= $photo->user->name; ?>
                            <br><br><p class="comment edit <?php echo ($userId === $photo->user->id && empty($photo->comment)) ? '' : 'hide' ?>">
                                <textarea id="add-comment_<?php echo $photo->user->id ?>" maxlength="100" placeholder="  Say something funny" data-model="Photo" data-id="<?php echo $photo->id; ?>" class="comment inline-edit form-control" data-name="comment" data-obj_Id="<?php echo $photo->id ?>"><?php echo $photo->comment; ?></textarea>
                            </p>
                            <p class="comment text <?php echo ($userId === $photo->user->id && !empty($photo->comment)) ? ' editable' : '' ?>"><span><?php echo!empty($photo->comment) ? '"' . $photo->comment . '"' : ''; ?></span></p>
                        </div>
                    </li>
                    <?php
                    $userIds = [$photo->user->id];
                    if (isset($shares)): foreach ($shares as $share):$userIds[] = $share->user_id;
                            ?>
                            <li class="photo-meta__item">
                                <figure class="photo-meta__img" <?php echo $photo_meta_style; ?>>
                                    <a href="/member/qt<?= $share->user_id; ?>"><img src="/upload/95x95_square<?= $share->user->avatar; ?>" alt="" width="95" height="95" style="border-radius: 50%;"></a>
                                </figure>
                                <div class="photo-meta__content" <?php echo $photo_meta_align; ?>>
                                    Shared by <?= $share->user->name; ?>
                                    <br><br><p class="comment edit <?php echo ($userId === $share->user_id && empty($share->comment)) ? '' : 'hide' ?>">
                                        <textarea  id="add-comment_<?php echo $share->user_id ?>" maxlength="100" placeholder="  Say something funny" data-model="SharingPhoto" data-id="<?php echo $share->id; ?>" class="comment inline-edit form-control" data-name="comment" data-obj_id="<?php echo $photo->id ?>"><?php echo $share->comment; ?></textarea>
                                    </p>
                                    <p class="comment <?php echo ($userId === $share->user_id && !empty($photo->comment)) ? 'editable' : '' ?>"><span><?php echo!empty($share->comment) ? '"' . $share->comment . '"' : ''; ?></span></p>
                                </div>
                            </li>
                            <?php
                        endforeach;
                    endif;
                    if (!Yii::$app->user->isGuest && !in_array($userId, $userIds)):
                        ?>
                        <li class="photo-meta__item share hide">
                            <figure class="photo-meta__img" <?php echo $photo_meta_style; ?>>
                                <a href="/member/qt<?= $userId; ?>"><img src="/upload/95x95_square<?= $user->avatar; ?>" alt="" width="95" height="95" style="border-radius: 50%;"></a>
                            </figure>
                            <div class="photo-meta__content" <?php echo $photo_meta_align; ?>>
                                Shared by <?= $user->name; ?>
                                <p class="comment edit ">
                                    <textarea id="add-comment_<?php echo $userId ?>" id="share-comment"  maxlength="100" placeholder="  Say something funny" data-model="SharingPhoto" data-id="" class="comment inline-edit form-control" data-name="comment" data-type="0" data-obj_id="<?php echo $photo->id ?>"></textarea>
                                </p>
                                <p class="comment hide editable"><span></span></p>
                            </div>
                        </li>
                        <?php
                    endif;
                    if ($photo->party_id > 0):
                        ?>
                        <li class="photo-meta__item">
                            <figure class="photo-meta__img" <?php echo $photo_meta_style; ?>>
                                <?php $banners = \app\models\Party::getBanners($photo->party_id); ?>
                                <a href="/party/<?= $photo->party->url ?>">
                                    <img src="<?= Yii::$app->params['flayerPath']; ?>/<?= $banners['thumbnail']; ?>" alt="" width="95" height="95">
                                </a>
                            </figure>
                            <div class="photo-meta__content" <?php echo $photo_meta_align; ?>>
                                <?= $photo->party->title; ?> Album
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="clearfix"></div>
            <br><br><br>
            <?php if (@$new === 1): ?>
                <a class="button-popup fancybox-save noline" style="width: 10px; padding: 16px 51px; margin-right: 20px; <?php echo $mobile_button_margin; ?>">Save</a>
                <a href="javascript:void(0)" url="/site/delete-photo/<?php echo $photo->id ?>" class="button-popup fancybox-cancel noline" style="width: 10px; padding: 16px 51px; margin-right: 20px;">Cancel</a>
            <?php elseif ($userId === $photo->user->id): ?>
                <a class="button-popup fancybox-save noline" style="width: 10px; padding: 16px 51px; margin-right: 20px; <?php echo $mobile_button_margin; ?>">Save</a>
                <?php if (!Yii::$app->user->isGuest && !\app\models\Likes::is_liked($photo->id)): ?>
                    <a href="<?= Url::to(['/user/like', 'id' => $photo->id]); ?>" class="like button-popup noline" style="width: 10px; padding: 16px 51px; margin-right: 20px; <?php echo $mobile_button_margin; ?>">Like</a>
                <?php endif; ?>
                <a href="javascript:void(0)" url="/site/delete-photo/<?php echo $photo->id ?>" class="button-popup fancybox-delete noline" style="width: 10px; padding: 16px 40px; margin-right: 20px;">Delete</a>
                <?php if ($photo->deleted_user === 1): ?>
                    <a href="javascript:void(0)" url="/site/undelete-photo/<?php echo $photo->id ?>" class="button-popup fancybox-undelete noline" style="width: 10px; padding: 16px 51px;  margin-right: 20px;">Share</a>
                <?php endif; ?>
            <?php elseif (!Yii::$app->user->isGuest): ?>
                <?php if (!Yii::$app->user->isGuest && !\app\models\Likes::is_liked($photo->id)): ?>
                    <a href="<?= Url::to(['/user/like', 'id' => $photo->id]); ?>" class="like button-popup noline" style="width: 10px; padding: 16px 51px; margin-right: 20px; <?php echo $mobile_button_margin; ?>">Like</a>
                <?php endif; ?>
                <?php if (!\app\models\SharingPhoto::haveShared($photo->id, $userId)): ?>
                    <a class="button-popup fancybox-share noline" style="width: 10px; padding: 16px 51px;  margin-right: 20px;">Share</a>
                    <a id="do-share" style="display: none; width: 10px; padding: 16px 51px;  margin-right: 20px;" class="button-popup fancybox-do-share noline">Share</a>
                    <a id="share-cancel" style="display: none; width: 10px; padding: 16px 51px;  margin-right: 20px;" class="button-popup fancybox-cancel noline">Cancel</a>
                <?php else: ?>
                    <a class="button-popup fancybox-save-share noline" style="width: 10px; padding: 16px 51px;  margin-right: 20px;">Save</a><?php echo $mobile_button_delete_margin; ?><?php echo $mobile_button_delete_margin; ?><?php echo $mobile_button_delete_margin; ?><?php echo $mobile_button_delete_margin; ?>
                    <a href="javascript:void(0)" url="/site/delete-photo/<?php echo $photo->id ?>" class="button-popup fancybox-delete noline" style="width: 10px; padding: 16px 40px;  margin-right: 20px;">Delete</a>
                <?php endif; ?>
            <?php else: ?>
                <br>
                <a href="#join" class="button-popup fancybox noline" style="width: 10px; padding: 16px 31px;  <?php echo $button_align_join ?>">Join the club</a>
                <a href="javascript:void()" class="button-popup fancybox fancybox-do-close noline" style="width: 10px; padding: 16px 51px; <?php echo $button_align_close; ?>">Close</a>
            <?php endif; ?>
            <p style="margin-top: 30px;" class="help-block help-block-error"></p>
        </div>
    </div>
    <?php
    if ($isMobile != true) {
        echo '</div>';
    }
    ?>
</section>
<script>
    $(document).ready(function () {
        $(this).scrollTop(0);
    });

if ($('.fancybox-opened').length == 0) {
    $('body').addClass('fancybox-lock');
}

//I am writing a clone of the fancybox clone function because it seems the fancybox-do-close detection doesn't work!
$.fancybox.originalClose = $.fancybox.close;
$.fancybox.close = function() {
    // Do whatever you want. Then do the default behavior:
    $('body').removeClass('fancybox-lock');
    location.reload();
    if(new_photo == 1){
            $.post('/site/delete-photo/'+photo_id, {new:'1'}).done(function(respose){
                location.reload();
            });
    }
    $.fancybox.originalClose();
};

    var userId = '<?php echo $userId; ?>';
    var photo_id = <?php echo $photo->id; ?>;
    var new_photo = <?php echo (@$new === 1) ? 1 : 0 ?>;
    var party_id = <?php echo $photo->party_id; ?>;
    $('.fancybox-do-close').click(function () {
        if (new_photo == 1) {
            $.post('/site/delete-photo/' + photo_id, {new : '1'}).done(function (respose) {
                location.reload();
            });
        }
        $.fancybox.close();
        return false;
    })

    $('.fancybox-share').click(function () {
        $(this).hide();
        $('#share-cancel').show();
        $('#do-share').show();
        $('li.photo-meta__item.share').removeClass('hide');
        return false;
    })
    $('.fancybox-do-share').click(function () {
        saveComment($('#share-comment'), function (response) {
            window.location = '/member/qt' + '<?= $userId; ?>';
        });
        return false;
    })
    $('.fancybox-save').click(function () {
        saveComment($('#add-comment'), function (response) {
            location.reload();
        });
        return false;
    })
    $('.fancybox-save-share').click(function () {
        saveComment($('#add-comment'), function (response) {
            location.reload();
        });
        return false;
    })
    $('.fancybox-cancel').click(function () {
        if (new_photo == 1) {
            $.post('/site/delete-photo/' + photo_id, {new : '1'}).done(function (respose) {
                location.reload();
            });
        }
        $.fancybox.close();
    })
    $('.fancybox-undelete').click(function () {
        $.post($(this).attr('url')).done(function (respose) {
            window.location = '/member/qt' + '<?= @$userId; ?>';
        });
        return false;
    })
    $('.fancybox-delete').click(function () {
        if (window.location.pathname.indexOf('party') === 1 || window.location.pathname.indexOf('parties') === 1) {
            $('p.help-block-error').html('Sorry. You can only delete photos from your own profile. Party albums are always public. <br><span margin-top:"8px;" style="font-size:12px;"> Do you really need to delete this photo? No sweat, just holla@941SocialClub.com</span>');
        } else {
            console.log(party_id);
            var mesg = '<div id="confirmation" style="margin-top: 50px;"><p>Are you sure you want to delete this photo from your profile?</p><br><br><br>';
            mesg += '<a  href="javascript:void(0)"  style="width: 10px; padding: 16px 51px; margin-right: 20px;" class="button-popup fancybox-do-delete noline">Yes</a>';
            mesg += '<a  href="javascript:void(0)"  style="width: 10px; padding: 16px 51px; margin-right: 20px;" class="button-popup fancybox-do-close noline" onclick="location.reload();">No</a>';
            if (party_id)
                mesg += '<br><br><br><br><p>This photo will still remain in the party album.<br>Use the "SHARE" button to add this photo back to your profile.</p></div>';
            $('#photo-popup').html(mesg).height(285);
            var url = $(this).attr('url');
            $('.fancybox-do-delete').click(function () {
                $.post(url, {new : '<?php echo @$new ?>'}).done(function (respose) {
                    location.reload();
                });
                location.reload();
            })
            $('.fancybox-do-close').click(function () {
                location.reload();
            })

        }


        return false;
    })
    $('.fancybox-close').click(function () {
        location.reload();
    })
    $('.like').off('click').on('click', function (e)
    {
        e.preventDefault();
        $.get(this.href, function (data)
        {
            $.fancybox(data);
        });
    }
    );
    function toggleComment(container) {
        $(container).find('p.comment').toggleClass('hide');
    }
    jQuery(function () {
        $('p.editable').on('click', function () {
            toggleComment($(this).closest('.photo-meta__content'));
        });
        $('a.share').on('click', function () {
            console.log('Click me');
            $('li.photo-meta__item.share').toggleClass('hide');
        });

        $('textarea.comment').keypress(function (e) {
            return;
            if (e.which == 13) {
                var field = $(this);
                console.log($(field).data());
                var data = $(field).data();
                data.val = $(field).val();
                $.post('/site/save-comment', data).done(function (respose) {
                    $('.fancybox-inner').html(respose);
                });
            }
        });
    });
    function saveComment(field, cb) {
        field = $('#add-comment_' + userId);
        var data = $(field).data();
        data.val = $(field).val();
        data.party_id = party_id;
        $.post('/site/save-comment', data).done(function (respose) {
            cb(respose);
        });
    }
</script>

