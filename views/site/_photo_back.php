<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<section id="join">
<div class="popup">
	<div class="photo">
		<figure class="photo__img">
			<img src="/upload/<?=$photo->image;?>" alt="" width="350" height="350">
			<ul class="photo__actions">
                <!--  SHARE -->
                <li class="photo__actions-item photo__actions-item--share">
                    <?php if($photo->allow2sharing && (!Yii::$app->user->isGuest)) {
                    if (\app\models\SharingPhoto::is_share($photo->id)) {
                        //You shared this photo если чего-нить выводить, то тут
                    ?>

                    <?php
                    } else {
                        $form = ActiveForm::begin(
                            [
                                'action' => Url::to(['/user/share-photo/', 'id' => $photo->id])
                            ]
                        );
                        if ($photo->allow2comment) {
                            ?>
                            <div class="form-group">
                                <?= Html::textInput('comment', $photo->comment); ?>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="form-group">
                            <?= Html::submitButton('Share photo', ['class' => 'button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    <?php
                    }
                    }
                    ?>
                </li>

                <!-- LIKE -->
                <?php
                if(!Yii::$app->user->isGuest){
                    if(!\app\models\Likes::is_liked($photo->id))
                    {
                        ?>
                        <li class="photo__actions-item photo__actions-item--like"><a href="<?=Url::to(['/user/like', 'id' => $photo->id]);?>" class="like">Like</a></li>
                    <?php
                    }
                    else {
                        ?>
                        <li class="photo__actions-item photo__actions-item--like"><span>Like</span></li>
                    <?php
                    }
                }
                ?>
			</ul>
		</figure>
		<div class="photo-meta">
			<ul class="photo-meta__list">
				<li class="photo-meta__item">
					<figure class="photo-meta__img">
						<img src="/upload/160x160<?=$photo->user->avatar;?>" alt="" width="95" height="95">
					</figure>
					<div class="photo-meta__content">
						<h3 class="photo-meta__title">PHOTO UPLOADED BY <?=$photo->user->name;?></h3>
						<p>
							“<?php if(isset($photo->share)) echo $photo->share->comment; else echo $photo->comment;?>”
						</p>
					</div>
				</li>
				<li class="photo-meta__item">
					<figure class="photo-meta__img">
						<img src="/upload/160x160<?=$photo->user->avatar;?>" alt="" width="95" height="95">
					</figure>
					<div class="photo-meta__content">
						<h3 class="photo-meta__title"><?=$photo->user->name;?></h3>
						<p>
							“<?=$photo->user->tag_line;?>”
						</p>
					</div>
				</li>
                <?php
                if($photo->party_id > 0)
                {
                    ?>
                    <li class="photo-meta__item">
                        <figure class="photo-meta__img">
                            <?php
                            $banners = \app\models\Party::getBanners($photo->party_id);
                            ?>
                            <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$banners['message_banner'];?>" alt="" width="95" height="95">
                        </figure>
                        <div class="photo-meta__content">
                            <h3 class="photo-meta__title">PHOTO FROM<br>
                                <?=$photo->party->title;?></h3>
                            <p>
                                <?=date('j.m @ g:i a', strtotime($photo->party->started_at));?> - <?=$photo->party->location;?>
                            </p>
                        </div>
                    </li>
                    <?php
                }
                ?>
			</ul>
		</div>
		<div class="photo-social">
			<div class="photo-social__conteiner">
							<span class="photo-social__box photo-social__box--left">
								<?= \app\models\Likes::countLike($photo->id);?><br>likes
							</span>
				<a href="<?=Url::to(['/site/load-more-like', 'id' => $photo->id]);?>" class="photo-social__box photo-social__box--right">
					See more
				</a>
				<ul class="photo-social__list">
                    <?php
                    echo $this->render('_social_photo_part', ['shares' => $likes]);
                    ?>
				</ul>
			</div>

			<div class="photo-social__conteiner">
                    <span class="photo-social__box photo-social__box--left">
                        <?= \app\models\SharingPhoto::countShare($photo->id);?><br>shares
                    </span>
				<a href="<?=Url::to(['/site/load-more-share', 'id' => $photo->id]);?>" class="photo-social__box photo-social__box--right">
					See more
				</a>
				<ul class="photo-social__list">
                    <?php
                    echo $this->render('_social_photo_part', ['shares' => $shares]);
                    ?>
				</ul>
			</div>
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
</script>
