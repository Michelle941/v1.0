<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<style>
    .photo-meta__content .photo-meta__title{margin-bottom: 5px;width: 275px;}
    .comment{margin: 0px; width: 277px; height: 70px;text-transform: uppercase; }
    .hide{display:none;}
    .photo-social{clear: both; margin-top: 15px;width: 100%;}
    .photo-social li{ display: inline;}
    .photo-social li:first-child{ float: left;}
    .photo-social li:last-child{ float: right;}
    a.fancybox-item.fancybox-close{display: none !important;}
    #photo-popup a.button{height: 50px; margin: 15px 0px; position: relative}
</style>
<div  class="popup">
    <div id="photo-popup"  class="photo" style="width: 770px">
        <figure class="photo__img">
            <img src="/upload/350x350<?=$photo->image;?>" alt="" width="350" height="350">
            <ul class="photo-social">
                <li><?= (int)$photo->view_count?> Views</li>
                <li class=""><?= \app\models\Likes::countLike($photo->id);?> likes</li>
                <li class=""><?= \app\models\SharingPhoto::countShare($photo->id);?> shares</li>
            </ul>
        </figure>
        <div class="photo-meta">
            <ul class="photo-meta__list">
                <li class="photo-meta__item">
                    <figure class="photo-meta__img">
                        <a href="/member/qt<?=$photo->user->id;?>"><img src="/upload/95x95_square<?=$photo->user->avatar;?>" alt="" width="95" height="95"></a>
                    </figure>
                    <div class="photo-meta__content">
                        <h3 class="photo-meta__title">PHOTO UPLOADED BY <?=$photo->user->name;?></h3>
                        <p class="comment edit <?php echo ($userId === $photo->user->id && empty($photo->comment))? '' : 'hide'?>">
                            <textarea id="add-comment_<?php echo $photo->user->id?>" maxlength="100" placeholder="Add comment" data-model="Photo" data-id="<?php echo $photo->id;?>" class="comment inline-edit form-control" data-name="comment" data-obj_Id="<?php echo $photo->id?>"><?php echo $photo->comment;?></textarea>
                        </p>
                        <p class="comment text <?php echo ($userId === $photo->user->id)? ' editable':''?>"><span><?php echo !empty($photo->comment) ? '"'.$photo->comment.'"' : '';?></span></p>
                    </div>
                </li>
                <?php $userIds = [$photo->user->id]; if(isset($shares)): foreach($shares as $share):$userIds[] = $share->user_id;?>
                    <li class="photo-meta__item">
                        <figure class="photo-meta__img">
                            <a href="/member/qt<?=$share->user_id;?>"><img src="/upload/95x95_square<?=$share->user->avatar;?>" alt="" width="95" height="95"></a>
                        </figure>
                        <div class="photo-meta__content">
                            <h3 class="photo-meta__title">PHOTO Shared BY <?=$share->user->name;?></h3>
                            <p class="comment edit <?php echo ($userId === $share->user_id && empty($share->comment))? '':'hide'?>">
                                <textarea  id="add-comment_<?php echo $share->user_id?>" maxlength="100" placeholder="Add comment" data-model="SharingPhoto" data-id="<?php echo $share->id;?>" class="comment inline-edit form-control" data-name="comment" data-obj_id="<?php echo $photo->id?>"><?php echo $share->comment;?></textarea>
                            </p>
                            <p class="comment <?php echo ($userId === $share->user_id)? 'editable':''?>"><span><?php echo !empty($share->comment) ? '"'.$share->comment.'"' : '';?></span></p>
                        </div>
                    </li>
                <?php endforeach; endif;if(!Yii::$app->user->isGuest && !in_array($userId, $userIds)):?>
                <li class="photo-meta__item share hide">
                    <figure class="photo-meta__img">
                        <a href="/member/qt<?=$userId;?>"><img src="/upload/95x95_square<?=$user->avatar;?>" alt="" width="95" height="95"></a>
                    </figure>
                    <div class="photo-meta__content">
                        <h3 class="photo-meta__title">PHOTO Shared BY <?=$user->name;?></h3>
                        <p class="comment edit ">
                            <textarea id="add-comment_<?php echo $userId?>" id="share-comment"  maxlength="100" placeholder="Add comment" data-model="SharingPhoto" data-id="" class="comment inline-edit form-control" data-name="comment" data-type="0" data-obj_id="<?php echo $photo->id?>"></textarea>
                        </p>
                        <p class="comment hide editable"><span></span></p>
                    </div>
                </li>
                <?php endif; if($photo->party_id > 0):?>
                    <li class="photo-meta__item">
                        <figure class="photo-meta__img">
                            <?php $banners = \app\models\Party::getBanners($photo->party_id); ?>
                            <a href="/party/<?=$photo->party->url?>">
                                <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$banners['thumbnail'];?>" alt="" width="95" height="95">
                            </a>
                        </figure>
                        <div class="photo-meta__content">
                            <h3 class="photo-meta__title">PHOTO FROM <?=$photo->party->title;?> Album</h3>
                        </div>
                    </li>
                <?php endif;?>
            </ul>
        </div>
        <div style="clear: both">
            <?php if(!Yii::$app->user->isGuest && !\app\models\Likes::is_liked($photo->id)): ?>
                <a href="<?=Url::to(['/user/like', 'id' => $photo->id]);?>" class="like button">like</a>
            <?php endif;?>
            <?php if(@$new === 1):?>
                <a class="button fancybox-save">Save</a>
                <a href="javascript:void(0)" url="/site/delete-photo/<?php echo $photo->id?>" class="button fancybox-cancel">Cancel</a>
            <?php elseif($userId === $photo->user->id):?>
                <a style="" class="button fancybox-save">Save</a>
                <a href="javascript:void(0)" url="/site/delete-photo/<?php echo $photo->id?>" class="button fancybox-delete">Delete</a>
                <?php if($photo->deleted_user === 1):?>
                    <a href="javascript:void(0)" url="/site/undelete-photo/<?php echo $photo->id?>" class="button fancybox-undelete">Share</a>
                <?php endif;?>
            <?php elseif(!Yii::$app->user->isGuest):?>
                <?php if(!\app\models\SharingPhoto::haveShared($photo->id, $userId)):?>
                <a class="button fancybox-share">Share</a>
                <a id="do-share" style="display: none;" class="button fancybox-do-share">Share</a>
                <a id="share-cancel" style="display: none;" class="button fancybox-cancel">Cancel</a>
                <?php else:?>
                    <a class="button fancybox-save-share">Save</a>
                    <a href="javascript:void(0)" url="/site/delete-photo/<?php echo $photo->id?>" class="button fancybox-delete">Delete</a>
                <?php endif;?>
            <?php else:?>
                <a href="#join" class="button fancybox">Join the club</a>
                <a href="javascript:viod()" class="button fancybox fancybox-do-close">Close</a>
            <?php endif;?>
            <p class="help-block help-block-error"></p>
        </div>
    </div>
</div>

<script>
    var userId = '<?php echo $userId;?>';
    var photo_id = <?php echo $photo->id;?>;
    var new_photo = <?php echo (@$new === 1) ? 1 : 0?>;
    var party_id = <?php echo $photo->party_id;?>;
    $('.fancybox-do-close').click(function(){
        if(new_photo == 1){
            $.post('/site/delete-photo/'+photo_id, {new:'1'}).done(function(respose){
                location.reload();
            });
        }
        $.fancybox.close();
        return false;
    })

    $('.fancybox-share').click(function(){
        $(this).hide();
        $('#share-cancel').show();
        $('#do-share').show();
        $('li.photo-meta__item.share').removeClass('hide');
        return false;
    })
    $('.fancybox-do-share').click(function(){
        saveComment($('#share-comment'), function(response){
            window.location = '/member/qt'+'<?=$userId;?>';
        });
        return false;
    })
    $('.fancybox-save').click(function(){
        saveComment($('#add-comment'), function(response){
            location.reload();
        });
        return false;
    })
    $('.fancybox-save-share').click(function(){
        saveComment($('#add-comment'), function(response){
            location.reload();
        });
        return false;
    })
    $('.fancybox-cancel').click(function(){
        if(new_photo == 1){
            $.post('/site/delete-photo/'+photo_id, {new:'1'}).done(function(respose){
                location.reload();
            });
        }
        $.fancybox.close();
    })
    $('.fancybox-undelete').click(function(){
        $.post($(this).attr('url')).done(function(respose){
            window.location = '/member/qt'+'<?=@$userId;?>';
        });
        return false;
    })
    $('.fancybox-delete').click(function(){
        if(window.location.pathname.indexOf('party') === 1 || window.location.pathname.indexOf('parties') === 1){
            $('p.help-block-error').text('You can only delete photos from your own profile');
        }else{
            console.log(party_id);
            var mesg = '<div id="confirmation"><p>Are you sure you want to delete this photo from your profile?</p>';
            mesg += '<a  href="javascript:void(0)"  style="clear: both" class="button fancybox-do-delete">Yes</a>';
            mesg += '<a  href="javascript:void(0)"  style="clear: both" class="button fancybox-do-close" onclick="location.reload();">No</a>';
            if(party_id)
                mesg += '<br><br><br><p>This photo will still remain in the party album.<br>Use the "share" button to add this photo back to your profile.</p></div>';
            $('#photo-popup').html(mesg).height(285);
            var url =$(this).attr('url');
            $('.fancybox-do-delete').click(function(){
                $.post(url, {new:'<?php echo @$new?>'}).done(function(respose){
                    location.reload();
                });
            })
            $('.fancybox-do-close').click(function(){
                location.reload();
            })

        }


        return false;
    })
    $('.fancybox-close').click(function(){
        location.reload();
    })
    $('.like').off('click').on('click', function(e)
        {
            e.preventDefault();
            $.get(this.href, function(data)
            {
                $.fancybox(data);
            });
        }
    );
    function toggleComment(container){
        $(container).find('p.comment').toggleClass('hide');
    }
    jQuery(function() {
        $('p.editable').on('click', function(){
            toggleComment($(this).closest('.photo-meta__content'));
        });
        $('a.share').on('click', function(){
            console.log('Click me');
            $('li.photo-meta__item.share').toggleClass('hide');
        });

        $('textarea.comment').keypress(function(e) { return ;
            if(e.which == 13) {
                var field = $(this); console.log($(field).data());
                var data = $(field).data();
                data.val = $(field).val();
                $.post( '/site/save-comment', data).done(function(respose){
                    $('.fancybox-inner').html(respose);
                });
            }
        });
    });
    function saveComment(field, cb){
        field = $('#add-comment_'+userId);
        var data = $(field).data();
        data.val = $(field).val();
        data.party_id = party_id;
        $.post( '/site/save-comment', data).done(function(respose){
            cb(respose);
        });
    }
</script>