<?php
use yii\helpers\Html;
?>
<style>
    .ticket{
        padding: 10px; border: 1px solid #808080; margin: 20px;
    }
</style>
<div class="form">
    <?php if(!empty($ticket)):?>
    <p><center>Here is your ticket for <?php echo $ticket->party->title?></center></p>
    <p><center>You can either print the ticket or Present it on your phone.</center></p>
        <ul class=" party">
                <li class="ticket" style="">
                    <div>
                        <h2 style="font-size: 18px"><center><b><?php echo $ticket->detail->title?></center></b></h2>
                        <div class="left image" style="float: left;margin-right:10px ">
                            <a class=" left dashboard__title-img" href="/party/<?php echo $ticket->party->url?>">
                                <img src="/image/<?php echo $ticket->party->thumbnail?>" alt="" width="135" height="135">
                            </a>
                        </div>
                        <div class="party-info">
                            <p><b><?php echo $ticket->party->title?></b></p>
                            <p>Date: <?php echo date('M d, Y', strtotime($ticket->party->started_at))?></p>
                            <p>Time: <?php echo date('H:i a', strtotime($ticket->party->started_at))?></p>
                            <p>Location: <?php echo $ticket->party->location?></p>
                        </div>
                        <div class="clear" style="clear: both;"></div><br><br>
                        <div class="left image" style="float: left;margin-right: 10px" >
                            <a style="float: left" class="left" href="/member/qt<?php 
				if(isset($ticket->user->id)){
				echo $ticket->user->id
				}else{}
?>">
                                <img src="/upload/160x160_square<?php echo $ticket->user->avatar?>" alt="" width="135" height="135">
                            </a>
                        </div>
                        <div class="party-info">
                            <p><b><?php echo $ticket->name. ' ' .$ticket->lastname?></b></p>
                        </div>
                        <div class="clear" style="clear: both;"></div><br><br>
                        <div class="left"> Ticket # <?php echo $ticket->ticket_number?></div>
                    </div>
                </li>
            <li class="do-not-print"><a href="/site/print-ticket/?hash=<?php echo $ticket->hash?>" class="print"><?= Html::submitButton('Print', ['class' => 'button']) ?></a></li>
        </ul>
        <br><br><br><br><br><br>

    <?php $tickets = \app\models\Party2profile::findByParty($ticket->party->id);?>
    <p><center>see who else is going</center></p><br><br>
    <ul class="members__list">
        <?php foreach ($tickets as $t): ?>
        <li class="members__item">
            <a href="<?=\yii\helpers\Url::to(['/site/member', 'id' => 'qt'.$t->user->id]);?>">
                <figure class="members__photo">
                    <img src="/upload/160x160_square<?=$t->user->avatar;?>" alt="" width="160" height="160">
                </figure>
            </a>
        </li>
    <?php endforeach;?>
    </ul>
    <a class="" href="/party/<?php echo $ticket->party->url?>"><?= Html::submitButton('See all', ['class' => 'button']) ?></a>
    <?php else:?>
        <p></p>
    <?php endif;?>
</div>
<br><br><br>
