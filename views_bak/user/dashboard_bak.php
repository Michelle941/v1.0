<?php
use app\models\Statistic;
use yii\helpers\Html;
use app\models\Ticket;

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
					<div class="notify new"></div>
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

		<?php foreach($titleUsers as $titleUserSingle): ?>
		<div id="titleUser_<?php echo $titleUserSingle ?>" class="dashboard-messages-right">
		    <?php foreach($message_roll[$titleUserSingle] as $msg): ?>
			<div class="<?php echo $msg->user_to === $user->id ? 'from message':'to message'?>">
			<div class="avatar" style="background-image: url('/upload/95x95_square<?php echo $msg->sender->avatar?>');"></div>
			<div class="timestamp"><?=$msg->getDate();?></div>
				<?= nl2br($msg->getText());?>

			</div><!-- message -->
	            <?php endforeach; //end message_roll loop ?>
		</div><!-- dasboard messages right -->	
		<div class="reply">

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

<section id="dashboard-notifications">

	<div class="margins-80">

		<h1>Recent Updates:</h1>

		<div class="dash-notes-icon">
			11/28/15
		</div><!-- dash notes icon -->
		<div class="dash-notes-flyer">
			<div class="dash-notes-flyer-icon event" style="background-image: url('');">
				&nbsp;
			</div><!-- dash notes flyer icon -->
		</div><!-- dash notes flyer -->
		<div class="dash-notes-text">
			<span>Name or Event Name</span> and the details of this. Something else.
		</div><!-- dash notes text -->
		<div class="clearfix"></div>	

		<div class="dash-notes-icon">
			11/28/15
		</div><!-- dash notes icon -->
		<div class="dash-notes-flyer">
			<div class="dash-notes-flyer-icon user" style="background-image: url('');">
				&nbsp;
			</div><!-- dash notes flyer icon -->
		</div><!-- dash notes flyer -->
		<div class="dash-notes-text">
			<span>Name or Event Name</span> and the details of this.
		</div><!-- dash notes text -->
		<div class="clearfix"></div>

		<div class="dash-notes-icon">
			11/28/15
		</div><!-- dash notes icon -->
		<div class="dash-notes-flyer">
			<div class="dash-notes-flyer-icon event" style="background-image: url('');">
				&nbsp;
			</div><!-- dash notes flyer icon -->
		</div><!-- dash notes flyer -->
		<div class="dash-notes-text">
			<span>Name or Event Name</span> and the details of this.
		</div><!-- dash notes text -->
		<div class="clearfix"></div>	

		<div class="dash-notes-icon">
			11/28/15
		</div><!-- dash notes icon -->
		<div class="dash-notes-flyer">
			<div class="dash-notes-flyer-icon user" style="background-image: url('');">
				&nbsp;
			</div><!-- dash notes flyer icon -->
		</div><!-- dash notes flyer -->
		<div class="dash-notes-text">
			<span>Name or Event Name</span> and the details of this.
		</div><!-- dash notes text -->
		<div class="clearfix"></div>

		<div class="dash-notes-icon">
			11/28/15
		</div><!-- dash notes icon -->
		<div class="dash-notes-flyer">
			<div class="dash-notes-flyer-icon event" style="background-image: url('');">
				&nbsp;
			</div><!-- dash notes flyer icon -->
		</div><!-- dash notes flyer -->
		<div class="dash-notes-text">
			<span>Name or Event Name</span> and the details of this.
		</div><!-- dash notes text -->
		<div class="clearfix"></div>	

		<div class="dash-notes-icon">
			11/28/15
		</div><!-- dash notes icon -->
		<div class="dash-notes-flyer">
			<div class="dash-notes-flyer-icon user" style="background-image: url('');">
				&nbsp;
			</div><!-- dash notes flyer icon -->
		</div><!-- dash notes flyer -->
		<div class="dash-notes-text">
			<span>Name or Event Name</span> and the details of this.
		</div><!-- dash notes text -->
		<div class="clearfix"></div>


	</div><!-- margins: dashboard notifications -->

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
}

function getNewmessage(message, avatar, user_id){
    var html = '<div class="to message">';
	html += message;
        html += '</div>';
        return html;
    }
    function reply(field){
      if($(field).val().trim().length > 0) {
                var data = $(field).data();
                data.text = $(field).val();
                $.post( '/user/reply', data).done(function(respose){
                    $(field).closest('div.reply').before(getNewmessage(data.text, data.avatar, data.user_id));
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

