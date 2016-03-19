<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<section id="single-photo" style="width: 1000px;">

    <div class="photo-left" style="background-image: url('/upload/<?=$photo->image;?>');">
        &nbsp;
        <div class="photo-left-snipe">
        <table class="table-blank"><tr><td>

            <h1>
                <i class="fa fa-heart-o"></i>
		<?= \app\models\Likes::countLike($photo->id);?> likes</li>
		<span>&bull;</span> 
                <i class="fa fa-eye"></i>
                <?= (int)$photo->view_count?> Views</li>
            </h1>
        
        </td></tr></table>
        </div><!-- small pic snipe -->
    </div><!-- photo left -->

    <div class="photo-right">

	 <a href="/member/qt<?=$photo->user->id;?>">
        <div class="small-pic" style="background-image: url('/upload/95x95_square<?=$photo->user->avatar;?>');">
            &nbsp;
        </div><!-- small pic -->
	</a>

        <div class="small-pic-text">

            <h1>
                <span style="font-weight: lighter;">Photo Uploaded by</span>
                <br />
                <?=$photo->user->name;?>
            </h1>

	<div class="photo-meta__content">
	    <p class="comment edit <?php echo ($userId === $photo->user->id && empty($photo->comment))? '' : 'hide'?>">
                            <textarea id="add-comment_<?php echo $photo->user->id?>" maxlength="100" placeholder="Add comment" data-model="Photo" data-id="<?php echo $photo->id;?>" class="comment inline-edit form-control" data-name="comment" data-obj_Id="<?php echo $photo->id?>"><?php echo $photo->comment;?></textarea>
                        </p>
                        <p class="comment text <?php echo ($userId === $photo->user->id)? ' editable':''?>"><span><?php echo !empty($photo->comment) ? '"'.$photo->comment.'"' : '';?></span></p>
	</div>

        </div><!-- small pic text -->

        <div class="clearfix"></div>

	<?php $userIds = [$photo->user->id]; if(isset($shares)): foreach($shares as $share):$userIds[] = $share->user_id;?>	
        <a href="/member/qt<?=$share->user_id;?>">
	<div class="small-pic" style="background-image: url('<?=$share->user_id;?>"><img src="/upload/95x95_square<?=$share->user->avatar;?>');">
            &nbsp;
        </div><!-- small pic -->
	</a>
        <div class="small-pic-text">

            <h1>
                <span style="font-weight: lighter;">Photo Shared by</span>
                <br />
            	 <?=$share->user->name;?>
	    </h1>

	 <p class="comment edit <?php echo ($userId === $share->user_id && empty($share->comment))? '':'hide'?>">
                                <textarea  id="add-comment_<?php echo $share->user_id?>" maxlength="100" placeholder="Add comment" data-model="SharingPhoto" data-id="<?php echo $share->id;?>" class="comment inline-edit form-control" data-name="comment" data-obj_id="<?php echo $photo->id?>"><?php echo $share->comment;?></textarea>
                            </p>
                            <p class="comment <?php echo ($userId === $share->user_id)? 'editable':''?>"><span><?php echo !empty($share->comment) ? '"'.$share->comment.'"' : '';?></span></p>

        </div><!-- small pic text -->

        <div class="clearfix"></div>

	<?php endforeach; endif;if(!Yii::$app->user->isGuest && !in_array($userId, $userIds)):?>
        <a href="/member/qt<?=$userId;?>">
	<div class="small-pic" style="background-image: url('<?=$share->user_id;?>"><img src="/upload/95x95_square<?=$share->user->avatar;?>');">
            &nbsp;
        </div><!-- small pic -->
                
        <div class="small-pic-text">
                
            <h1>
                <span style="font-weight: lighter;">Photo Shared by</span>
                <br />
                 <?=$user->name;?>
            </h1>
        
	<p class="comment edit ">
                            <textarea id="add-comment_<?php echo $userId?>" id="share-comment"  maxlength="100" placeholder="Add comment" data-model="SharingPhoto" data-id="" class="comment inline-edit form-control" data-name="comment" data-type="0" data-obj_id="<?php echo $photo->id?>"></textarea>
                        </p>
                        <p class="comment hide editable"><span></span></p>

        </div><!-- small pic text -->
            
        <div class="clearfix"></div>

	<?php endif; if($photo->party_id > 0):?>
	<a href="/party/<?=$photo->party->url?>">
	<div class="small-pic" style="background-image: url('<?=Yii::$app->params['flayerPath'];?>/<?=$banners['thumbnail'];?>');">
            &nbsp;
        </div><!-- small pic -->
	</a>

        <div class="small-pic-text">

            <h1>
                <span style="font-weight: lighter;">Photo from</span>
                <br />
                <?=$photo->party->title;?>
	    </h1>

            <p>
                &nbsp;
            </p>

        </div><!-- small pic text -->
	<?php endif;?>
        <div class="clearfix"></div>

    </div><!-- photo right -->

    <div class="clearfix"></div>

    <button>
        Like this Photo
    </button>

    <button>
        Share this Photo
    </button>

</section><!-- upgrade section 2 -->
