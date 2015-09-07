<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Statistic;
use yii\widgets\ActiveForm;
?>
    <div id="upgrade">
        <div class="popup">
            <div class="form popup__form profile-update">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'enctype'=>'multipart/form-data',],
                ]); ?>
                <div class="form__row">
                    <div class="form__half">
                        <?= $form->field($model, 'name', ['template' => "{hint}\n{error}\n{input}"])->textInput(['placeholder' => "First name"]);?>
                    </div>
                    <div class="form__half">
                        <?= $form->field($model, 'last_name', ['template' => "{hint}\n{error}\n{input}"])->textInput(['placeholder' => "Last name"]);?>
                    </div>
                </div>

                <div class="form__row">
                    <?= $form->field($model, 'tag_line', ['template' => "{hint}\n{error}\n{input}"])->textInput(['placeholder' => "Tagline"]);?>
                </div>

                <div class="form__row">
                    <div class="form__half">
	                    <div class="profile-update-photo profile-update-photo-item">
		                    <div class="profile-update-photos__actions">
			                    <span class="profile-update-photos__title">Upload from:</span>
			                    <div class="profile-update-photos__button">
				                    <span class="profile-update-photos__device">Computer</span>
				                    <div class="input__file">
					                    <input type="file" accept="image/*" name="User[photo5]">
				                    </div>
			                    </div>
			                    <a href="/user/instagram-photos?type=user&key=photo5" class="fancybox-ajax profile-update-photos__button">Instagram</a>
		                    </div>
		                    <div class="input__file-image">
                                <?php if($photo = \app\models\Photo::getOne($model->photo5_id)){ ?>
                                    <img src="/upload/255x255_square<?=$photo->image;?>" alt=""/>
                                <?php } ?>
		                    </div>
	                    </div>
                    </div>
                    <div class="form__half">
                        <ul class="profile-update-photos">
                            <li class="profile-update-photos__item profile-update-photo-item">
	                            <div class="profile-update-photos__actions">
		                            <span class="profile-update-photos__title">Upload from:</span>
		                            <div class="profile-update-photos__button">
			                            <span class="profile-update-photos__device">Computer</span>
			                            <div class="input__file">
				                            <input type="file" accept="image/*" name="User[photo1]">
			                            </div>
		                            </div>
		                            <a href="/user/instagram-photos?type=user&key=photo1" class="fancybox-ajax profile-update-photos__button">Instagram</a>
	                            </div>
	                            <div class="input__file-image">
                                    <?php if($photo = \app\models\Photo::getOne($model->photo1_id)){ ?>
                                        <img src="/upload/255x255_square<?=$photo->image;?>" alt=""/>
                                    <?php } ?>
                                </div>
                            </li>
                            <li class="profile-update-photos__item profile-update-photo-item">
	                            <div class="profile-update-photos__actions">
		                            <span class="profile-update-photos__title">Upload from:</span>
		                            <div class="profile-update-photos__button">
			                            <span class="profile-update-photos__device">Computer</span>
			                            <div class="input__file">
				                            <input type="file" accept="image/*" name="User[photo2]">
			                            </div>
		                            </div>
		                            <a href="/user/instagram-photos?type=user&key=photo2" class="fancybox-ajax profile-update-photos__button">Instagram</a>
	                            </div>
	                            <div class="input__file-image">
                                    <?php if($photo = \app\models\Photo::getOne($model->photo2_id)){ ?>
                                        <img src="/upload/255x255_square<?=$photo->image;?>" alt=""/>
                                    <?php } ?>
                                </div>
                            </li>
                            <li class="profile-update-photos__item profile-update-photo-item">
	                            <div class="profile-update-photos__actions">
		                            <span class="profile-update-photos__title">Upload from:</span>
		                            <div class="profile-update-photos__button">
			                            <span class="profile-update-photos__device">Computer</span>
			                            <div class="input__file">
				                            <input type="file" accept="image/*" name="User[photo3]">
			                            </div>
		                            </div>
		                            <a href="/user/instagram-photos?type=user&key=photo3" class="fancybox-ajax profile-update-photos__button">Instagram</a>
	                            </div>
	                            <div class="input__file-image">
                                    <?php if($photo = \app\models\Photo::getOne($model->photo3_id)){ ?>
                                        <img src="/upload/255x255_square<?=$photo->image;?>" alt=""/>
                                    <?php } ?>
                                </div>
                            </li>
                            <li class="profile-update-photos__item profile-update-photo-item">
	                            <div class="profile-update-photos__actions">
		                            <span class="profile-update-photos__title">Upload from:</span>
		                            <div class="profile-update-photos__button">
			                            <span class="profile-update-photos__device">Computer</span>
			                            <div class="input__file">
				                            <input type="file" accept="image/*" name="User[photo4]">
			                            </div>
		                            </div>
		                            <a href="/user/instagram-photos?type=user&key=photo4" class="fancybox-ajax profile-update-photos__button">Instagram</a>
	                            </div>
	                            <div class="input__file-image">
                                    <?php if($photo = \app\models\Photo::getOne($model->photo4_id)){ ?>
                                        <img src="/upload/255x255_square<?=$photo->image;?>" alt=""/>
                                    <?php } ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="form__row">
                    <div class="form__half">
                        <h3 class="form__title">RELATIONSHIP STATUS [SELECT ONE. DUH]</h3>
                        <div class="input__radio input__radio--2">
                            <?php
                            foreach(app\helpers\HandBook::getRelation() as $k => $relation)
                            {
                                echo '<input type="radio" name="User[relation_status]" value="'.$k.'" id="'.$relation.'" '.(($model->relation_status == $k)? 'checked' : '').'><label for="'.$relation.'">'.$relation.'</label>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form__half">
                        <h3 class="form__title">GENDER [SELECT ONE]</h3>
                        <div class="input__radio input__radio--2">
                            <?php
                            foreach(app\helpers\HandBook::getGender() as $k => $gender)
                            {
                                echo '<input type="radio" name="User[gender]" value="'.$k.'" id="'.$gender.'" '.(($model->gender == $k)? 'checked' : '').'><label for="'.$gender.'">'.$gender.'</label>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="form__row">
                    <h3 class="form__title">WORK [GET CREATIVE BUT STAY HONEST. EVERYONE KNOWS YOU’RE NOT A PIMP AT LIFE]</h3>
                    <div class="radio-group">
                        <ul>
                            <?php
                            $work = explode('#', $model->work);
                            foreach(\app\helpers\HandBook::getWorkHeader() as $k=>$w)
                            {
                                echo "<li class='radio-group__item'>
                                                <div class='radio-group__container'>
                                                    <div class='radio-group__label'>
                                                        <input type='radio' name='User[work]' id='{$w}' value='{$k}' ".(($k == $work[0])? 'checked': '').">
                                                        <label for='{$w}'><span>{$w}</span></label>
                                                    </div>";
                                                    $style = ($k<8) ? '':'display:none';
                                                        echo "<div class='radio-group__input' style='{$style}'>
                                                        <input type='text' name='work_description[{$k}]' " . (($k == $work[0] && !empty($work[1])) ? "value='{$work[1]}'" : '') . ">
                                                    </div>";
                                echo "    </div>
                                      </li>";
                            }
                            ?>
                            <li class="radio-group__item">
                                <div class="radio-group__container">
                                    <div class="radio-group__label">
                                        <input type="radio" name="User[work]" id="custom-work" value="10"  <?=($work[0] == 10) ? 'checked': '' ;?>>
                                        <label for="custom-work"></label>
                                    </div>
                                    <div class="radio-group__input radio-group__input--sep">
                                        <div class="radio-group__input-left">
                                            <input type="text" name="work_description[10]"  <?=(($work[0]==10 && !empty($work[1])) ? "value='{$work[1]}'" : '')?>>
                                        </div>
                                        <div class="radio-group__input-sep">AT</div>
                                        <div class="radio-group__input-right">
                                            <input type="text" name="custom-work" <?=(($work[0]==10 && !empty($work[2])) ? "value='{$work[2]}'" : '')?>>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="radio-group__item">
                                <div class="radio-group__container">
                                    <div class="radio-group__label">
                                        <input type="radio" name="User[work]" id="custom-work2" value="11"  <?=($work[0] == 11) ? 'checked': '' ;?>>
                                        <label for="custom-work2"></label>
                                    </div>
                                    <div class="radio-group__input">
                                        <input type="text" name="work_description[11]" <?=(($work[0]==11 && !empty($work[1])) ? "value='{$work[1]}'" : '')?>>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="form__row">
                    <h3 class="form__title">THINGS YOU LOVE [SELECT 3. PROBABLY BEST IF YOU COME UP WITH YOUR OWN]</h3>
                    <div class="radio-group max-checkbox" data-max="3">
                        <ul>
                            <?php
                            $loveAnswers = explode('#$%', $model->love);
                            foreach(\app\helpers\HandBook::getLoveHeader() as $k=>$love)
                            {
                                ?><li class='radio-group__item'>
                                        <div class='radio-group__container'>
                                          <div class='radio-group__label'>
                                           <input data-max='3' type='checkbox' name='User[love][]' id='<?=$love;?>' value='<?=$love;?>' <?=(in_array($love, $loveAnswers)) ? 'checked' : ''?>>
                                           <label for='<?=$love;?>'><span><?=$love;?></span></label>
                                          </div>
                                        </div>
                                       </li><?php
                                $n = array_search(trim($love), $loveAnswers);
                                if($n !== false)
                                {
                                    unset($loveAnswers[$n]);
                                }
                            }
                            $value = array_shift($loveAnswers);
                            ?>
                            <li class="radio-group__item">
                                <div class="radio-group__container">
                                    <div class="radio-group__label">
                                        <input data-max='3' type="checkbox" name="love" id="love-custom" <?=($value) ? "value='{$value}' checked" : "value=''";?>>
                                        <label for="love-custom"></label>
                                    </div>
                                    <div class="radio-group__input">
                                        <input type="text" name="love-custom-val" <?=($value) ? "value='{$value}'" : "value=''";?>>
                                    </div>
                                </div>
                            </li>
                            <?php
                            $value = array_shift($loveAnswers);
                            ?>

                            <li class="radio-group__item">
                                <div class="radio-group__container">
                                    <div class="radio-group__label">
                                        <input data-max='3' type="checkbox" name="love" id="love-custom2" <?=($value) ? "value='{$value}' checked" : "value=''";?>>
                                        <label for="love-custom2"></label>
                                    </div>
                                    <div class="radio-group__input">
                                        <input type="text" name="love-custom-val2" <?=($value) ? "value='{$value}'" : "value=''";?>>
                                    </div>
                                </div>
                            </li>
                            <?php
                            $value = array_shift($loveAnswers);
                            ?>
                            <li class="radio-group__item">
                                <div class="radio-group__container">
                                    <div class="radio-group__label">
                                        <input data-max='3' type="checkbox" name="love" id="love-custom3" <?=($value) ? "value='{$value}' checked" : "value=''";?>>
                                        <label for="love-custom3"></label>
                                    </div>
                                    <div class="radio-group__input">
                                        <input type="text" name="love-custom-val3" <?=($value) ? "value='{$value}'" : "value=''";?>>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="form__row">
                    <button type="submit" class="button">Update profile</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
<?php if( Yii::$app->request->isAjax) { ?>
	<script>
		jQuery(function() {
			// File upload
			$('.input__file-image').each(function() {
				var image = $(this).find('img');
				if(image.length) {
					var bigger;
					if($(this).width() <= $(this).height()) {
						bigger = 'width'
					} else {
						bigger = 'height'
					}
					$(this).closest('.input__file-image')
						.removeClass('width', 'height')
						.addClass(bigger);
				}
			});

			$('.input__file input').on('change', function() {
				var input = this;
				if (input.files && input.files[0]) {
					var reader = new FileReader();
					reader.onload = function (e) {
						var image = new Image();
						image.src = e.target.result;

						image.onload = function() {
							var bigger;
							if(this.width <= this.height) {
								bigger = 'width'
							} else {
								bigger = 'height'
							}
							$(input).closest('.profile-update-photo-item').find('.input__file-image')
								.removeClass('width', 'height')
								.addClass(bigger)
								.html('<img src="' + this.src + '">');
						};
					};
					reader.readAsDataURL(input.files[0]);
				}
			});
			!isMobile.any() || $('.profile-update-photos__device').text('Device');

			// Max checkbox size
			(function() {
				var container = $('.max-checkbox');
				var checkboxes = container.find(':checkbox');
				checkboxes.on('change', function(e) {
					if(checkboxes.filter(':checked').length > container.data('max')) {
						$(this).prop('checked', false);
					}

				});
			})();
		});
	</script>
<?php } ?>