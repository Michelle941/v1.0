<style>
    ul.dashboard__list{margin: 0px 0px 33px}
    ul.dashboard__list .dashboard__title{background:#CDCDCD none repeat scroll 0% 0% !important; }
    ul.dashboard__list li.dashboard__item.active div.dashboard__content{max-height: 500px; overflow: scroll; padding: 20px;}
    li.message{margin: 15px; clear: both;}
    li.message .title{text-align: center; color: #808080;  font-size: 8px}
    li.message div.body{
        border: 1px solid #808080;
        margin: 10px;
        border-radius: 18px;
        padding: 10px;
        background-color: #F7F7F7;
        min-height:30px;
    }
    li.message.update div.body{
        border: none;
        background-color: #ffffff;
        border-radius: 0px;
        border-bottom: 1px solid #808080;
        margin: 0px;
        padding: 0px;;
    }
    li.message div.title{text-align: center;width: 70%;}
    li.message div.title.right{float: right;}

    li.message div.body.left{text-align: left;width: 70%;}
    li.message div.body a{float: left;margin-right: 10px;}
    li.message div.body.right{text-align: right; float: right;width: 70%;}
    li.message div.body.right a{float: right;margin-left: 10px}
    li.message div.body .text{padding: 0 10px; text-align: justify; text-justify: inter-word;}
    li.message div.body .text.bold{font-weight: bolder;}
    li.message.last div.body{
        background-color: #ffffff;
        border: none;
        padding: 0px;
        margin-right:30px;
    }
    li.message.last div.body textarea{
        background-color: #ffffff;
        border: 1px solid #808080;
        border-radius: 18px;
        padding: 10px;
        width: 100%;

    }
    .alert-success{color: darkgreen}
    .buy-tickets__title{margin: 10px; width: 6%; margin-left: 0px;}
    .buy-tickets__title.ticket-title{width: 50%;}
    .buy-tickets__title.flash{width: 15%;}
    .buy-tickets__title.flash-price{width: 11%;}
    .party .dashboard__content .image{width: 18%; float:left}
    .party .dashboard__content .tickets{width: 82%;float: left;padding-top: 20px}
    .members__item{margin: 20px 10px}

</style>
<?php
use app\models\Statistic;
use yii\helpers\Html;
use app\models\Ticket;

//TODO: onclik помечать прочтенным. Ответ на письмо.
?>
<div>
    <?php if($flashMessages):?>
    <center class="dashboard flashMessages">
        <?php foreach( $flashMessages as $key => $flashMessages) : foreach($flashMessages as $flashMessage) : ?>
            <div class="alert alert-<?php echo $key?>"><?php echo $flashMessage?></div>
        <?php endforeach;endforeach;?>
    </center>
    <?php endif;?>
    <section class="dashboard">
        <header class="dashboard__header">
            <ul class="dashboard__meta">
                <li><b><?=Statistic::countByType($user->id, Statistic::TYPE_PROFILE_VIEWS);?></b> PROFILE VIEWS</li>
                <li><b><?=\app\models\Following::countFollowing($user->id);?></b> FOLLOWERS</li>
            </ul>
        </header>
        <h3 class=""><span class="dashboard__title-text">941 Messages</span></h3>
        <ul class="dashboard__list">
            <li class="dashboard__item">
                <h3 class="dashboard__title">
                    <figure class="dashboard__title-img">
                        <img src="/images/30x30.png" alt="" width="30" height="30">
                    </figure>
                    <span class="dashboard__title-text">941 Social club sent you <?php echo count($notification941) ?> <?php echo count($notification941)> 1? 'Messages': 'Message'?></span>
                </h3>
                <div class="dashboard__content">
                    <ul>
                        <?php foreach($notification941 as $not): $notice = $not->getNotification(); $not->markAsRead();?>
                            <li class="message">
                                <div class="title"><?=$not->getDate();?></div>
                                <div class="body">
                                    <a href="javascript:void()">
                                        <img style="float: left" src="/images/30x30.png" alt="" width="30" height="30">
                                    </a>
                                    <span><?= nl2br($notice->getContent($user));?></span>
                                </div>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </li>
        </ul>
        <?php if(!empty($messages)):?>
            <div>
                <h3 class="">
                    <span class="dashboard__title-text">Member messages</span>
                </h3>
            </div>
        <ul class="dashboard__list">
            <?php $userIds = array($user->id => true); foreach($messages as $message) : ?>
                <?php $titleUser = ($message->sender->id === $user->id) ? $message->receiver : $message->sender;?>
                <?php if(isset($userIds[$titleUser->id])) continue;?>
                <?php $userIds[$titleUser->id] = true;?>
                <li class="dashboard__item">
                    <h3 class="dashboard__title">
                        <figure class="dashboard__title-img">
                            <img src="/upload/30x30_square<?php echo $titleUser->avatar?>" alt="" width="30" height="30">
                        </figure>
                        <span class="dashboard__title-text"><?php echo $titleUser->name?> <?php echo $message->getCountStr($user->id);?></span>
                    </h3>
                    <div class="dashboard__content">
                        <ul>
                            <?php foreach($message->getMessages() as $msg): ?>
                                <li class="message">
                                    <div class="title <?php echo $msg->user_to === $user->id ? 'left':'right'?>">
                                        <?=$msg->getDate();?>
                                    </div>
                                    <div class="body <?php echo $msg->user_to === $user->id ? 'left':'right'?>">

                                        <?php if($msg->user_to === $user->id):?>
                                        <a href="/member/qt<?php echo $msg->user_from?>">
                                            <img src="/upload/30x30_square<?php echo $msg->sender->avatar?>" alt="" width="30" height="30">
                                        </a>
                                        <div class="text <?php echo $msg->read_at ? '' : 'bold'?>">
                                            <?php if(!Yii::$app->user->can('premium')): ?>
                                                <?php echo Yii::$app->controller->renderPartial('/notice/buy_premium');?>
                                            <?php else:?>
                                                <?= nl2br($msg->getText());?>
                                                <?php if(!$msg->read_at){$msg->read_at = time();$msg->save();}?>
                                            <?php endif;?>
                                        </div>
                                        <?php else:?>
                                            <a href="/member/qt<?php echo $user->id?>">
                                                <img src="/upload/30x30_square<?php echo $user->avatar?>" alt="" width="30" height="30">
                                            </a>
                                            <div  class="text">
                                                <?= nl2br($msg->getText());?>
                                            </div>
                                        <?php endif?>
                                    </div>
                                </li>
                            <?php endforeach;?>
                            <li class="message last form">
                                <div class="body right">
                                    <textarea class="form-control" placeholder="SAY SOMETHING FUNNY" data-user_id="<?php echo $user->id?>" data-avatar="<?php echo $user->avatar?>" data-user_to="<?php echo $titleUser->id?>"></textarea>
                                </div>
                                <div class="body right"><?= Html::submitButton('Reply', ['class' => 'button reply-message']) ?></div>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>
        <?php endif;?>
        <?php if(!empty($memberNotification)):?>
            <div>
                <h3 class=""><span class="dashboard__title-text">Member Notifications</span></h3>
                <ul class="dashboard__list">
                <?php foreach($memberNotification as $userId => $notifications): $titleUser = $notifications['user']; ?>
                    <li class="dashboard__item">
                        <h3 class="dashboard__title">
                            <figure class="dashboard__title-img">
                                <img src="/upload/30x30_square<?php echo $titleUser->avatar?>" alt="" width="30" height="30">
                            </figure>
                            <span class="dashboard__title-text"><?php echo $titleUser->name?></span>
                        </h3>
                        <div class="dashboard__content">
                            <ul>
                                <?php foreach($notifications['notifications'] as $notification): ?>
                                    <li class="message update">
                                        <div class="body">
                                            <div  class="text">
                                                <a style="float:left;margin-right: 5px;" href="/member/qt<?php echo $titleUser->id?>"><?php echo $titleUser->name?></a>
                                                <span><?= $notification->value .' '.$notification->getTime();?></span>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </li>
                <?php endforeach;?>
                </ul>
            </div>
      <?php endif;?>
        <?php if(!empty($parties)):?>
        <div>
            <h3 class=""><span class="dashboard__title-text">Party Notifications</span></h3>
            <ul class="dashboard__list party">
                <?php foreach($parties as $party):?>
                <?php if(!empty($party->sales)):foreach($party->sales as $sale): ?>
                    <li class="dashboard__item ">
                        <h3 class="dashboard__title">
                            <figure class="dashboard__title-img">
                                <img src="/image/<?php echo $sale->thumbnail?>" alt="" width="30" height="30">
                            </figure>
                            <span class="dashboard__title-text"><?php echo $sale->getDashboardTitle($party->title)?></span>
                        </h3>
                        <div class="dashboard__content ">
                            <div class="left image">
                                <a class="dashboard__title-img members__item" href="/party/<?php echo $party->url?>">
                                    <img src="/image/<?php echo $sale->thumbnail?>" alt="" width="135" height="135">
                                </a>
                            </div>
                            <ul class="tickets">
                                <?php foreach($sale->ticket as $ticket):?>
                                    <li class="">
                                        <div class="buy-tickets__item body">
                                            <label for="buy-50" class="buy-tickets__title ticket-title">
                                                <?=$ticket->title;?>
                                            </label>
                                            <?php if(!empty($ticket->actual_price)):?>
                                                <label class="buy-tickets__title actual_price flash-price">
                                                    <strike>$<?=number_format($ticket->actual_price, 2, '.', '');?></strike></label>
                                            <?php endif;?>
                                            <label for="buy-50" class="buy-tickets__title ">
                                                <b>$<?=number_format($ticket->price, 2, '.', '');?></b>
                                            </label>
                                            <?php if(!empty($ticket->actual_price)):?>
                                                <label for="buy-50" class="buy-tickets__title flash">Flash Sale</label>
                                            <?php endif;?>
                                        </div>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                            <p style="clear:both;padding: 20px 10px; font-size: 18px">Check out who already bought tickets</p>
                            <ul>
                                <?php $users = \app\models\Party2profile::findByParty($party->id); if(!empty($users)) :foreach($users as $user):?>
                                <li class="members__item">
                                    <a href="/member/qt<?=@$user->user->id;?>">
                                        <figure class="members__photo">
                                            <img src="/upload/160x160_square<?=@$user->user->avatar;?>" alt="" width="160" height="160">
                                        </figure>
                                    </a>
                                </li>
                                <?php endforeach; endif;?>
                            </ul>
                        </div>
                    </li>
                <?php endforeach; elseif(count($party->photo) >=14):?>
                <li class="dashboard__item ">
                    <h3 class="dashboard__title">
                        <span class="dashboard__title-text">Check out photos from <?php echo $party->title?></span>
                        <figure class="dashboard__title-img">
                            <img src="/image/<?php echo $party->thumbnail?>" alt="" width="30" height="30">
                        </figure>
                    </h3>
                    <div class="dashboard__content ">
                        <ul class="">
                            <?php foreach($party->photo  as $key =>  $photo): if ($key> 5) break;?>
                                <li class="members__item">
                                    <a class="fancybox-ajax" href="/site/photo/<?=$photo->id?>" value="/site/photo/<?=$photo->id?>">
                                        <figure class="members__photo">
                                            <img src="/upload/160x160_square<?=$photo->image;?>" alt="" width="160" height="160">
                                        </figure>
                                    </a>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </li>
                <?php endif; endforeach;?>
            </ul>
        </div>
        <?php endif;?>
        <?php if(!empty($partyTickets)):?>
            <div>
                <h3 class=""><span class="dashboard__title-text">My tickets</span></h3>
                <ul class="dashboard__list party">
                    <?php foreach($partyTickets as $partyId => $tickets):?>
                    <li class="dashboard__item ">
                        <h3 class="dashboard__title">
                            <figure class="dashboard__title-img">
                                <img src="/image/<?php echo $tickets['party']->thumbnail?>" alt="" width="30" height="30">
                            </figure>
                            <span class="dashboard__title-text">Tickets for <?php echo $tickets['party']->title?></span>
                        </h3>
                        <div class="dashboard__content ">
                            <ul class="form">
                                <p><center>You can also access your tickets under "My Ticket" menu</center></p>
                                <br><br>
                                <div class="body"><a class=""  target="_blank"  href="/user/print-ticket?party_id=<?=$tickets['party']->id?>"><?= Html::submitButton('Print all tickets', ['class' => 'button']) ?></a></div>

                                <?php foreach($tickets['tickets']  as $key =>  $ticket):?>
                                    <li class="ticket" style="border: 1px solid gray; padding: 10px; margin-bottom: 10px;">
                                        <div>
                                            <h2><center><b><?php echo $ticket->detail->title?></center></b></h2>
                                            <div class="left image">
                                                <a class=" left dashboard__title-img" href="/party/<?php echo $ticket->party->url?>">
                                                    <img src="/image/<?php echo $ticket->party->thumbnail?>" alt="" width="135" height="135">
                                                </a>
                                            </div>
                                            <div class="party-info">
                                                <p><?php echo $ticket->party->title?></p><br>
                                                <p>Date: <?php echo date('M d, Y', strtotime($ticket->party->started_at))?></p><br>
                                                <p>Time: <?php echo date('H:i a', strtotime($ticket->party->started_at))?></p><br>
                                                <p>Location: <?php echo $ticket->party->location?></p>
                                            </div>
                                            <div class="clear" style="clear: both;"></div><br><br>
                                            <div class="left image">
                                                <a style="float: left" class="left" href="/member/qt<?php echo $user->id?>">
                                                    <img src="/upload/160x160_square<?php echo $ticket->user->avatar?>" alt="" width="135" height="135">
                                                </a>
                                            </div>
                                            <div class="party-info">
                                                <p><?php echo $ticket->name. ' '.$ticket->lastname?></p>
                                            </div>
                                            <div class="clear" style="clear: both;"></div><br><br>
                                            <div class="left"> Ticket # <?php echo $ticket->ticket_number?></div>
                                            <br><br>
                                            <div class="body"><a class="" target="_blank"  href="/user/print-ticket?party_id=<?=$ticket->party->id?>&ticket_id=<?=$ticket->id?>"><?= Html::submitButton('Print this ticket', ['class' => 'button']) ?></a></div>
                                        </div>
                                        <br><br>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>

        <?php endif;?>
    </section>
</div>

<?php
$js = <<<JS
function closeFancyBox(){
  $.fancybox.close();
}
function getNewmessage(message, avatar, user_id){
    var html = '<li class="message">';
        html += '<div class="body right">';
        html += '<a href="/member/qt'+user_id+'">';
        html += '<img style="float: right" src="/upload/30x30_square'+avatar+'" alt="" width="30" height="30">';
        html += '</a>';
        html += '<div class="text">'+message+'</div>';
        html += '</div>';
        html += '</li>';
        return html;
    }
    function reply(field){
      if($(field).val().trim().length > 0) {
                var data = $(field).data();
                data.text = $(field).val();
                $.post( '/user/reply', data).done(function(respose){
                    $(field).closest('li.message').before(getNewmessage(data.text, data.avatar, data.user_id));
                    $(field).val('');
                });
            }
    }
    jQuery(function() {
        $('.reply-message').on('click', function() {
          reply($(this).closest('li.message').find('textarea'));
        });
    });
JS;
$this->registerJs($js);
?>