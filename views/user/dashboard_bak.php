<?php
use app\models\Statistic;
use yii\helpers\Html;
use app\models\Ticket;

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\helpers\HandBook;

$current_date = (string)date( 'M d Y h:i A');
//TODO: onclik помечать прочтенным. Ответ на письмо.
?>
<section id="dashboard-vitals">

	<div class="margins-80">

		<h1>
			<?php echo $user->name; ?>
		</h1>

		<p>
			<i class="fa fa-eye fa-fw"></i><?=Statistic::countByType($user->id, Statistic::TYPE_PROFILE_VIEWS);?> Views 
			<i class="fa fa-street-view fa-fw"></i><?=\app\models\Following::countFollowing($user->id);?> Followers
		</p>

	</div><!-- margins: dashboard vitals -->

	<div class="clearfix"></div>


<div class="form popup__form profile-update">
<?php $form = ActiveForm::begin(['id' => 'dashparty-form',
                ]); ?>
<br><br><span style="font-size: 30px; margin-left: 25%;">Are you going to this party? 
Mr. Marina Competition</span>
<div class="profile-update-toggles-left" style="text-align: center; font-size: 30px; margin-left: 25%; margin-top: 20px;">

			<?php echo   $form->field($dashparty, 'user_id',
                                ['options' => ['value'=> $user->id] ])->hiddenInput(['value'=> $user->id])->label(false);?>
			<?php echo   $form->field($dashparty, 'party_id',
                                ['options' => ['value'=> 13] ])->hiddenInput(['value'=> 13])->label(false);?>
			<div class="input__radio input__radio--2">
			<?php  echo '<input type="radio" name="Dashparty[going_flag]" value="1" uncheckValue="null" id="Going" '.(($dashparty->going_flag == 1)? 'checked' : '').'><label for="Going">Going</label>';?>
	                <?php  echo '<input type="radio" name="Dashparty[going_flag]" value="0" uncheckValue="null" id="Not Going" '.(($dashparty->going_flag == 0)? 'checked' : '').'><label for="Not Going">Not Going</label>';?>
			</div>

                </div><!-- profile update toggles right -->

<?php ActiveForm::end(); ?>
<div class="clearfix"></div>

</section><!-- dashboard vitals section -->




<section id="dashboard-messages">

	<div class="margins-80">

<?php if(!empty($messages)): //the $messages array contains all messages grouped by sender-receiver: one msg per group, ordered by latest message ?>
		<div class="dashboard-messages-left">
	 <?php $userIds = array($user->id => true); foreach($messages as $message) : ?>
	     <?php $titleUser = ($message->sender->id === $user->id) ? $message->receiver : $message->sender;?>
	     <?php if(isset($userIds[$titleUser->id])) continue;?>
             <?php $userIds[$titleUser->id] = true;?>
	     	<?php $titleUsers[] = $titleUser->id; //assemble list of all titleUsers (sender-receiver unique)
		      $iterator = 0;  
		      foreach($message->getMessages() as $msg): ?>
		<?php $message_roll[$titleUser->id][$iterator] = $msg; $iterator++; ?>
		<?php endforeach; //end message_roll loop ?>
			<a id="User_<?php echo $titleUser->id; ?>" href="javascript:showonlyone('titleUser_<?php echo $titleUser->id; ?>');"> <div class="message-left-cell">
				<div class="message-left-cell-sender">
					<div class="<?php if($message->getCountStr($user->id)){ echo 'notify new';}else{}  ?>"></div>
					<div class="message-left-cell-sender-avatar" style="background-image: url('/upload/95x95_square<?php echo $titleUser->avatar; ?>');">
					</div><!-- message left cell sender avatar -->
				</div><!-- message left cell sender -->
				<div class="message-left-cell-preview">
					<p>
						<?php echo $titleUser->name; ?>
					</p>
					<?= nl2br($msg->getText());?>
				</div><!-- message left cell preview -->
				<div class="clearfix"></div>	
			</div><!-- message left cell --></a>
	     <?php endforeach; //end messages loop ?>
		</div><!-- dashboard messages left -->

		<?php $counter = 0;
			foreach($titleUsers as $titleUserSingle): ?>
		<?php //display the most recent chat by default 
			$display_none = '';
			if ($counter > 0){
				$display_none = 'display: none;';
			}
		?>
		<div id="titleUser_<?php echo $titleUserSingle ?>" class="dashboard-messages-right" style="<?php echo $display_none; ?>">
		    <?php foreach($message_roll[$titleUserSingle] as $msg): ?>


                                            <?php if(!Yii::$app->user->can('premium')): ?>
						<div class="<?php echo $msg->user_to === $user->id ? 'from message':'to message'?>">
						<?php 
							if($msg->user_to === $user->id){
							echo Yii::$app->controller->renderPartial('/notice/buy_premium', ['user' => $user]);
							}
						?>
                                                <div class="avatar" style="background-image: url('/upload/95x95_square<?php echo $msg->sender->avatar?>');"></div>
                                                <div class="timestamp"><?=$msg->getDate();?></div>
                                                <?php 
							if($msg->user_to != $user->id){
								echo nl2br($msg->getText());	
								if(!$msg->read_at){$msg->read_at = time();$msg->save();}
							}
						?>
                                            <?php else:?>
						<div class="<?php echo $msg->user_to === $user->id ? 'from message':'to message'?>">
			                        <div class="avatar" style="background-image: url('/upload/95x95_square<?php echo $msg->sender->avatar?>');"></div>
                        			<div class="timestamp"><?=$msg->getDate();?></div>
                                		<?= nl2br($msg->getText());?>
                                                <?php if(!$msg->read_at){$msg->read_at = time();$msg->save();}?>
                                            <?php endif;?>


			</div><!-- message -->
	            <?php
			$counter++; 
			endforeach; //end message_roll loop ?>
		</div><!-- dasboard messages right -->	
		<div id="titleUser_<?php echo $titleUserSingle ?>" class="reply" style="<?php echo $display_none; ?>">

			<div class="inputs">
				<input type="text" style="font-family: 'Questrial', sans-serif;" class="form-control" placeholder="Say Something Funny" data-user_id="<?php echo $user->id?>" data-avatar="<?php echo $user->avatar?>" data-user_to="<?php echo $titleUserSingle?>">

				<?= Html::submitButton('Reply', ['class' => 'button reply-message']) ?>
				
			</div><!-- inputs -->
		
		</div><!-- reply -->
		<?php endforeach; //end titleUsers loop?>
<?php endif;?>
		<div class="clearfix"></div>

	</div><!-- margins: dashboard messages -->

	<div class="clearfix"></div>

</section><!-- dashboard messages section -->

	<div class="clearfix"></div>

</section>

<?php
$js = <<<JS
function closeFancyBox(){
  $.fancybox.close();
}

window['showonlyone'] = showonlyone;
function showonlyone(thechosenone) {
     $('.dashboard-messages-right').each(function(index) {
          if ($(this).attr("id") == thechosenone) {
               $(this).show(0);
          }
          else {
               $(this).hide(0);
          }
     });

     $('.reply').each(function(index) {
          if ($(this).attr("id") == thechosenone) {
               $(this).show(0);
          }
          else {
               $(this).hide(0);
          }
     });

}

$(document).ready(function(){
  $('.dashboard-messages-right').animate({
  scrollTop: $('.dashboard-messages-right').get(0).scrollHeight}, 0);
});

document.getElementById("Going").onchange = function() {
    document.getElementById("dashparty-form").submit();
}
document.getElementById("Not Going").onchange = function() {
    document.getElementById("dashparty-form").submit();
}


var user_avatar = "$user->avatar";
var current_date = "$current_date"; 
function getNewmessage(message, avatar, user_id){
    var html = '<div class="to message">';
	html += '<div class="avatar" style="background-image: url(\'/upload/95x95_square' + user_avatar + '\');"></div>';
	html += message;
	html += '<div class="timestamp">' + current_date + '</div>';
        html += '</div>';
        return html;
    }
    function reply(field){
      if($(field).val().trim().length > 0) {
                var data = $(field).data();
                data.text = $(field).val();
                $.post( '/user/reply', data).done(function(respose){
                    $(field).closest('div.reply').prev('div').children('div').last().after(getNewmessage(data.text, data.avatar, data.user_id));
                    $(field).val('');
                });
            }
    }
    jQuery(function() {
        $('.reply-message').on('click', function() {
          reply($(this).closest('div.reply').find('input'));
        });
    });
JS;
$this->registerJs($js);
?>

