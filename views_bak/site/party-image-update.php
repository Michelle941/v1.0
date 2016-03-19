<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<section id = "join">
<style>
    .photo-meta__content .photo-meta__title{margin-bottom: 5px;}
    .comment{margin: 0px; width: 277px; height: 70px;text-transform: uppercase; }
    .comment.hide{display:none;}
</style>
<div class="popup">
    <div class="photo" style="width: 770px">
        <figure class="photo__img">
            <img src="/upload/350x350<?=$photo->image;?>" alt="" width="350" height="350">
        </figure>
        <div class="photo-meta">
            <ul class="photo-meta__list">
                <li class="photo-meta__item">
                    <figure class="photo-meta__img">
                        <a href="/member/qt<?=$photo->user->id;?>"><img src="/upload/95x95_square<?=$photo->user->avatar;?>" alt="" width="95" height="95"></a>
                    </figure>
                    <div class="photo-meta__content">
                        <h3 class="photo-meta__title">PHOTO UPLOADED BY <?=$photo->user->name;?></h3>
                        <p class="comment edit <?php echo ($userId === $photo->user->id)? '':'hide'?>">
                            <textarea  maxlength="100" placeholder="Add comment" model="Photo" id="<?php echo $photo->id;?>" class="comment inline-edit form-control" name="comment"><?php echo $photo->comment;?></textarea>
                        </p>
                        <p class="comment text <?php echo ($userId === $photo->user->id)? 'hide editable':''?>">"<span><?php echo $photo->comment;?></span>"</p>
                    </div>
                </li>
                <?php if(isset($photo->share)):?>
                <li class="photo-meta__item">
                    <figure class="photo-meta__img">
                        <a href="/member/qt<?=$photo->share->user_id;?>"><img src="/upload/95x95_square<?=$photo->share->avatar;?>" alt="" width="95" height="95"></a>
                    </figure>
                    <div class="photo-meta__content">
                        <h3 class="photo-meta__title">PHOTO Shared BY <?=$photo->share->user->name;?></h3>
                        <p class="edit <?php echo ($userId === $photo->share->user_id)? '':'hide'?>">
                            <textarea  maxlength="100" placeholder="Add comment" model="SharingPhoto" id="<?php echo $photo->share->id;?>" class="comment inline-edit  form-control" name="comment"><?php echo $photo->share->comment;?></textarea>
                        </p>
                        <p class="comment <?php echo ($userId === $photo->share->user_id)? 'hide editable':''?>">"<span><?php echo $photo->share->comment;?></span>"</p>
                    </div>
                </li>
                <?php endif;?>

                <?php
                if($photo->party_id > 0)
                {
                    ?>
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
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>
</section>
<script>

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
            console.log('i am here');
            toggleComment($(this).closest('.photo-meta__content'));
        });

        $('textarea.comment').keypress(function(e) {
            if(e.which == 13) {
                var field = $(this);
                $.post( "/user/save-inline", {
                    model: $(field).attr('model'),
                    id: $(field).attr('id'),
                    field: 'comment',
                    val: $(field).val()
                }).done(function(data){
                    var container =$(field).closest('.photo-meta__content');
                    $(container).find('p.comment span').text($(field).val());
                    toggleComment(container);
                });
            }
        });
    });
</script>
