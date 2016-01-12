<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<section id="join">
<div class="popup">
	<div class="photo">
		<figure class="photo__img">
			<img src="/upload/<?=$image;?>" alt="" width="350" height="350">
			<ul class="photo__actions">
                <!-- LIKE -->
                <?php
                if(!Yii::$app->user->isGuest){
                    if(!\app\models\Likes::is_liked($id))
                    {
                        ?>
                        <li class="photo__actions-item photo__actions-item--like"><a href="<?=Url::to(['/user/like', 'id' => $id]);?>" class="like">Like</a></li>
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
						<img src="/upload/160x160_square<?=$user->avatar;?>" alt="" width="95" height="95">
					</figure>
					<div class="photo-meta__content">
						<h3 class="photo-meta__title">PHOTO UPLOADED BY <?=$user->name;?></h3>
					</div>
				</li>
			</ul>
		</div>
		<div class="photo-social">
			<div class="photo-social__conteiner">
							<span class="photo-social__box photo-social__box--left">
								<?= \app\models\Likes::countLike($id);?><br>likes
							</span>
				<a href="<?=Url::to(['/site/load-more-like', 'id' => $id]);?>" class="photo-social__box photo-social__box--right">
					See more
				</a>
				<ul class="photo-social__list">
                    <?php
                    echo $this->render('_social_photo_part', ['shares' => $likes]);
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
