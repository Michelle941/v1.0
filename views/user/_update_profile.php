<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Statistic;
use yii\widgets\ActiveForm;
use app\helpers\HandBook;
?>
<?php 
$isMobile = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Mobile'); 
if($isMobile==true){
$deviceName="Device";
$deviceClassNew="custom-file-input3";
$deviceClassChange="custom-file-input4";
}
else{
$deviceName="Computer";
$deviceClassNew="custom-file-input";
$deviceClassChange="custom-file-input2";
}
?>
<section id="profile-update-basic">
 <?php $form = ActiveForm::begin([
		    'id' => 'profile-update-form',
                    'options' => [
                        'enctype'=>'multipart/form-data',
			//'onsubmit'=>'setFormSubmitting()',
			],
                ]); ?>
	<div class="margins-80">

		<p>
			Don't Be Basic. Update Your Profile.
		</p>

	</div><!-- margins: don't be basic -->

</section><!-- profile update don't be basic section -->

<section id="profile-update-name">

	<div class="margins-80">

		<div onclick="" class="profile-update-avatar" style="background-image: url('/upload/255x255_square<?=$model->avatar; ?>');">
                        <a href="/user/update-avatar/" class="fancybox-ajax">
			<div class="profile-update-avatar-inner" style="border-radius: 50%; overflow: hidden;">
                        <table class="table-blank" style="border-radius: 50%; overflow: hidden;"><tr style="border-radius: 50%; overflow: hidden;"><td style="border-radius: 50%; overflow: hidden;">
                                        Update Photo
                        </td></tr></table>
                        </div><!-- profile update avatar inner -->
			</a>
                </div><!-- profile update avatar -->


		<div class="profile-update-names">

			<?= $form->field($model, 'name', ['template' => "{hint}\n{error}\n{input}"])->textInput(['placeholder' => "First name", 'class' => "profile-update-firstname"]);?>

			<?= $form->field($model, 'last_name', ['template' => "{hint}\n{error}\n{input}"])->textInput(['placeholder' => "Last name", 'class' => "profile-update-lastname"]);?>

			<div class="clearfix"></div>

			<?= $form->field($model, 'tag_line', ['template' => "{hint}\n{error}\n{input}"])->textInput(['maxlength' => 100,'placeholder' => "Your Tagline Here", 'class' => "profile-update-tagline"]);?>

		</div><!-- profile update names -->

	</div><!-- margins: profile update name -->

</section><!-- profile update name section -->

<section id="profile-update-pictures">

	<div class="margins-80">

		<div class="profile-update-pictures-lead" style="margin-left: 0;">
			You’re a hottie and we know it. Upload five favorite photos of yourself. Don’t worry about the order. All photos are constantly shuffled. You can delete or update these five photos at any time.
		</div><!-- profile update picture single -->

		<?php if($photo = \app\models\Photo::getOne($model->photo5_id)){ ?>
		<div onclick="" class="profile-update-pictures-single" style="background-image: url('/upload/255x255_square<?=$photo->image;?>');">
		<div class="profile-update-single-inner">
                        <table class="table-blank"><tr><td>
                                <label class="<?php echo $deviceClassChange; ?>" style="content: Change Photo - Upload from <?php echo $deviceName; ?>;">
                                <input id="photo5" type="file" accept="image/*" name="User[photo5]" style="display:none;"></label><br><br>
                                <button href="/user/instagram-photos?type=user&key=photo5" class="fancybox-ajax button-follow" style="width: 245px;">Change Photo - <br>Upload From Instagram
                                </button>
                        </td></tr></table>
                        </div><!-- profile update single inner -->
		<?php }else{ ?>
		<div onclick="" class="profile-update-pictures-single" style="background-image: url('../../images/white-plus.png');">
                <div class="profile-update-single-inner">
                        <table class="table-blank"><tr><td>
                                <label class="<?php echo $deviceClassNew ?>">
                                <input id="photo5" type="file" accept="image/*" name="User[photo5]" style="display:none;"></label><br><br>
                                <button href="/user/instagram-photos?type=user&key=photo5" class="fancybox-ajax button-follow" style="width: 245px;">Upload From Instagram
                                </button>
                        </td></tr></table>
                        </div><!-- profile update single inner -->
		<?php } ?>
		</div><!-- profile update picture single -->

		<?php if($photo = \app\models\Photo::getOne($model->photo1_id)){ ?>
                <div onclick="" class="profile-update-pictures-single" style="background-image: url('/upload/255x255_square<?=$photo->image;?>');">
                <div class="profile-update-single-inner">
                        <table class="table-blank"><tr><td>
                                <label class="<?php echo $deviceClassChange; ?>" style="content: Change Photo - Upload from <?php echo $deviceName; ?>;">
                                <input id="photo1" type="file" accept="image/*" name="User[photo1]" style="display:none;"></label><br><br>
                                <button href="/user/instagram-photos?type=user&key=photo1" class="fancybox-ajax button-follow" style="width: 245px;">Change Photo - <br>Upload From Instagram
                                </button>
                        </td></tr></table>
                        </div><!-- profile update single inner -->
                <?php }else{ ?>
                <div onclick="" class="profile-update-pictures-single" style="background-image: url('../../images/white-plus.png');">
                <div class="profile-update-single-inner">
                        <table class="table-blank"><tr><td>
                                <label class="<?php echo $deviceClassNew; ?>">
                                <input id="photo1" type="file" accept="image/*" name="User[photo1]" style="display:none;"></label><br><br>
                                <button href="/user/instagram-photos?type=user&key=photo1" class="fancybox-ajax button-follow" style="width: 245px;">Upload From Instagram
                                </button>
                        </td></tr></table>
                        </div><!-- profile update single inner -->
                <?php } ?>
                </div><!-- profile update picture single -->

		<?php if($photo = \app\models\Photo::getOne($model->photo2_id)){ ?>
                <div onclick="" class="profile-update-pictures-single" style="margin-left: 0; background-image: url('/upload/255x255_square<?=$photo->image;?>');">
                <div class="profile-update-single-inner">
                        <table class="table-blank"><tr><td>
                                <label class="<?php echo $deviceClassChange; ?>" style="content: Change Photo - Upload from <?php echo $deviceName; ?>;">
                                <input id="photo2" type="file" accept="image/*" name="User[photo2]" style="display:none;"></label><br><br>
                                <button href="/user/instagram-photos?type=user&key=photo2" class="fancybox-ajax button-follow" style="width: 245px;">Change Photo - <br>Upload From Instagram
                                </button>
                        </td></tr></table>
                        </div><!-- profile update single inner -->
                <?php }else{ ?>
                <div onclick="" class="profile-update-pictures-single" style="margin-left: 0; background-image: url('../../images/white-plus.png');">
                <div class="profile-update-single-inner">
                        <table class="table-blank"><tr><td>
                                <label class="<?php echo $deviceClassNew; ?>">
                                <input id="photo2" type="file" accept="image/*" name="User[photo2]" style="display:none;"></label><br><br>
                                <button href="/user/instagram-photos?type=user&key=photo2" class="fancybox-ajax button-follow" style="width: 245px;">Upload From Instagram
                                </button>
                        </td></tr></table>
                        </div><!-- profile update single inner -->
                <?php } ?>
                </div><!-- profile update picture single -->

		<?php if($photo = \app\models\Photo::getOne($model->photo3_id)){ ?>
                <div onclick="" class="profile-update-pictures-single" style="background-image: url('/upload/255x255_square<?=$photo->image;?>');">
                <div class="profile-update-single-inner">
                        <table class="table-blank"><tr><td>
                                <label class="<?php echo $deviceClassChange; ?>" style="content: Change Photo - Upload from <?php echo $deviceName; ?>;">
                                <input id="photo3" type="file" accept="image/*" name="User[photo3]" style="display:none;"></label><br><br>
                                <button href="/user/instagram-photos?type=user&key=photo3" class="fancybox-ajax button-follow" style="width: 245px;">Change Photo - <br>Upload From Instagram
                                </button>
                        </td></tr></table>
                        </div><!-- profile update single inner -->
                <?php }else{ ?>
                <div onclick="" class="profile-update-pictures-single" style="background-image: url('../../images/white-plus.png');">
                <div class="profile-update-single-inner">
                        <table class="table-blank"><tr><td>
                                <label class="<?php echo $deviceClassNew; ?>">
                                <input id="photo3" type="file" accept="image/*" name="User[photo3]" style="display:none;"></label><br><br>
                                <button href="/user/instagram-photos?type=user&key=photo3" class="fancybox-ajax button-follow" style="width: 245px;">Upload From Instagram
                                </button>
                        </td></tr></table>
                        </div><!-- profile update single inner -->
                <?php } ?>
                </div><!-- profile update picture single -->

		<?php if($photo = \app\models\Photo::getOne($model->photo4_id)){ ?>
                <div onclick="" class="profile-update-pictures-single" style="background-image: url('/upload/255x255_square<?=$photo->image;?>');">
                <div class="profile-update-single-inner">
                        <table class="table-blank"><tr><td>
                                <label class="<?php echo $deviceClassChange; ?>" style="content: Change Photo - Upload from <?php echo $deviceName; ?>;">
                                <input id="photo4" type="file" accept="image/*" name="User[photo4]" style="display:none;"></label><br><br>
                                <button href="/user/instagram-photos?type=user&key=photo4" class="fancybox-ajax button-follow" style="width: 245px;">Change Photo - <br>Upload From Instagram
                                </button>
                        </td></tr></table>
                        </div><!-- profile update single inner -->
                <?php }else{ ?>
                <div onclick="" class="profile-update-pictures-single" style="background-image: url('../../images/white-plus.png');">
                <div class="profile-update-single-inner">
                        <table class="table-blank"><tr><td>
                                <label class="<?php echo $deviceClassNew; ?>">
                                <input id="photo4" type="file" accept="image/*" name="User[photo4]" style="display:none;"></label><br><br>
                                <button href="/user/instagram-photos?type=user&key=photo4" class="fancybox-ajax button-follow" style="width: 245px;">Upload From Instagram
                                </button>
                        </td></tr></table>
                        </div><!-- profile update single inner -->
                <?php } ?>
                </div><!-- profile update picture single -->

	</div><!-- margins: profile update pictures -->

	<div class="clearfix"></div>

</section><!-- profile updates pictures section -->

<div class="form popup__form profile-update">
<section id="profile-update-toggles">

	<div class="margins-80">

		<div class="profile-update-toggles-left">

			<p>
                                Relationship Status (Select One. Duh!):
                        </p>
			<div class="input__radio input__radio--2">
                            <?php
                            foreach(app\helpers\HandBook::getRelation() as $k => $relation)
                            {
                                echo '<input type="radio" name="User[relation_status]" value="'.$k.'" id="'.$relation.'" '.(($model->relation_status == $k)? 'checked' : '').'><label for="'.$relation.'">'.$relation.'</label>';
                            }
                            ?>
                        </div>
		</div><!-- profile update toggles left -->

		<div class="profile-update-toggles-right">

			<p>
				Gender:
			</p>
			
			<div class="input__radio input__radio--2">
                            <?php
                            foreach(app\helpers\HandBook::getGender() as $k => $gender)
                            {
                                echo '<input type="radio" name="User[gender]" value="'.$k.'" id="'.$gender.'" '.(($model->gender == $k)? 'checked' : '').'><label for="'.$gender.'">'.$gender.'</label>';
                            }
                            ?>
                        </div>

		</div><!-- profile update toggles right -->

	</div><!-- margins: update toggles -->

	<div class="clearfix"></div>

</section><!-- update toggles section -->


<section id="profile-update-fields-work">

	<div class="margins-80">
		<div class="form__row">
                    <p>Work (Get creative but stay honest. Everyone knows you're not a pimp at life)</p>
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
                                        <div class="radio-group__input-sep">at</div>
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

	<div class="clearfix"></div>

</section><!-- profile update fields section -->

<section id="profile-update-fields-loves">

	<div class="margins-80">

		<div class="form__row">
                    <p>Things you love (Select 3. Probably best if you come up with your own)</p>
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


	</div><!-- margins: profile update fields loves -->

	<div class="clearfix"></div>

</section><!-- profile update fields loves section -->
</div><!-- end old styling -->

<section id="profile-update-submit">

	<div class="margins-80">

		<button type="submit">

			Update Profile

		</button>

	</div><!-- margins: profile update submit -->
	<?php ActiveForm::end(); ?>
</section><!-- profile update submit section -->

<div id="dialog" title="Uploading Photo" style="display: none;">Uploading...</div>

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
<script>
        jQuery(function() {
                $('.profile-update-single-inner input').on('change', function() {
                        var input = this;
                        if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                reader.onload = function (e) {
					$(document).ready(function() {
    						$("#dialog").dialog();
					});	
					$(input).next('.input__file-image').html('<img src="' + e.target.result + '">')
                                };
                                reader.readAsDataURL(input.files[0]);
                        }
                });
        });

document.getElementById("photo5").onchange = function() {
    document.getElementById("profile-update-form").submit();
}
document.getElementById("photo1").onchange = function() {
    document.getElementById("profile-update-form").submit();
}
document.getElementById("photo2").onchange = function() {
    document.getElementById("profile-update-form").submit();
}
document.getElementById("photo3").onchange = function() {
    document.getElementById("profile-update-form").submit();
}
document.getElementById("photo4").onchange = function() {
    document.getElementById("profile-update-form").submit();
}

/*
var formSubmitting = false;
var setFormSubmitting = function() { formSubmitting = true; };

window.onload = function() {
    window.addEventListener("beforeunload", function (e) {
        if (formSubmitting) {
            return undefined;
        }

        var confirmationMessage = 'It looks like you have been editing your profile. '
                                + 'Make sure you click on "Upate Profile" button  to save your changes!';

        (e || window.event).returnValue = confirmationMessage; //Gecko + IE
        return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
    });
};
*/
</script>
