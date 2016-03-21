<?php
use app\models\Statistic;
use yii\helpers\Html;
use app\models\Ticket;

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\helpers\HandBook;
use app\models\Party2profile;


$current_date = (string)date( 'M d Y h:i A');
//TODO: onclik помечать прочтенным. Ответ на письмо.
?>
<section id="dashboard-vitals">

	<div class="margins-80">
		<h1><?php echo $user->name; ?></h1>

		<p>
			<i class="fa fa-eye fa-fw"></i><?=Statistic::countByType($user->id, Statistic::TYPE_PROFILE_VIEWS);?> Views 
			<i class="fa fa-street-view fa-fw"></i><?=\app\models\Following::countFollowing($user->id);?> Followers
		</p>

	</div><!-- margins: dashboard vitals -->

	<div class="clearfix"></div>


    <div class="form popup__form profile-update">
        <div class="parties">
            <?php foreach($dashParties as $party): $party_id = $party->id; if(!Party2profile::is_shared($party_id, $user->id) ): ?>
            <?php
            $banners = \app\models\Party::getBanners($party_id);
            $party_name = $party->title;
            ?>
            <div style="margin-top: 20px; height: 200px">
                <div>
                    <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$banners['thumbnail'];?>" style="height: 200px; width: 200px; margin-left: 150px; float: left;">
                </div>
                <span style="font-size: 30px; margin-left: 50px;">Are you going to <?php echo $party_name; ?>?</span>
                <div class="radio-group" style="text-align: center; font-size: 25px; margin-left: 28%; margin-top: 20px;">
                    <div class="radio-group__label">
                        <input name="going_<?php echo $party_id?>" class="going" type="radio" value="1" uncheckvalue="null" id="going_<?php echo $party_id?>" data-party-id="<?php echo $party_id?>" data-party-url="<?php echo $party->url?>">
                        <label for="going_<?php echo $party_id?>"><?php echo $party['yes']?></label>
                    </div>
                    <br>
                    <div class="radio-group__label">
                        <input name="going_<?php echo $party_id?>"  class="going" type="radio" value="0" uncheckvalue="null" id="not_going_<?php echo $party_id?>" data-party-id="<?php echo $party_id?>" data-party-url="<?php echo $party->url?>">
                        <label for="not_going_<?php echo $party_id?>"><?php echo $party['no']?></label>
                    </div>
                </div><!-- profile update toggles right -->
            </div>
            <div class="clearfix"></div>

        <?php endif; endforeach;?>
    </div>
    </div>
</section>
<section id="dashboard-messages">
    <div class="margins-80">
        <p style="text-align: center">Messaging feature coming soon!   Give us a few days to get our sh*t together!</p>
    </div>
</section>

<?php
$js = <<<JS
function closeFancyBox(){
  $.fancybox.close();
}

var submitted_party_id = "";
var submitted_party_name = "";
if(submitted_party_id > 0){
window.location="../party/" + submitted_party_name;
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
  $('input[type=radio]').change(function() {

    var data = {} ;
    var url = $(this).data('party-url') ;
    data.party_id = $(this).data('party-id');
    data.val = $(this).val();
    data.user_id = $user->id;
    console.log(data);
    $.post( '/user/dparty',data).done(function(response){
      if(data.val == 1){
        location.reload();
      }else{
        window.location.href = '/party/'+url;
      }
    });

  });

});

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

