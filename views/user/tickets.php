<?php use yii\helpers\Html; ?>
<style>
    ul.dashboard__list{margin: 0px 0px 33px}
    ul.dashboard__list .dashboard__title{background:#CDCDCD none repeat scroll 0% 0% !important; }
    ul.dashboard__list li.dashboard__item.active div.dashboard__content{max-height: 500px; overflow: scroll; padding: 20px;}
    .party .dashboard__content .image{width: 18%; float:left}
</style>
<div>
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
                                        <div class="party-info"><p><?php echo $ticket->name. ' '.$ticket->lastname?></p></div>
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
</div>