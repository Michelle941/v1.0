<?php
use yii\helpers\Html;

//TODO: onclik помечать прочтенным. Ответ на письмо.
?>

<html>
    <head>
        <title></title>
        <style>
            body {
                color: #000;
                font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                text-transform: uppercase;
                font-size: 14px;
            }
            li{list-style-type: none;}
            .page-break	{ display: block; page-break-before: always; }
            .button{
                background: #3B3B3B;
                color: #fff;
                text-align: center;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                width: 100%;
                border: 0;
                font: 500 14px/31px "Helvetica Neue",Helvetica,Arial,sans-serif;
                text-transform: uppercase;
                cursor: pointer;
                display: inline-block;
            }
            .ticket{
                padding: 10px; border: 1px solid #808080; margin: 20px;
            }
            @media print {
                .do-not-print {
                    display: none;
                }
                .ticket{border: 0px solid #808080; margin: 0px}
            }
        </style>
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script>
            $(document).ready(function(){
                $('.print').on('click', function(){
                    window.print();
                });
            })

        </script>
    </head>
<body style="width: 800px; margin: 0 auto">
<?php if(!empty($ticket)):?>
    <div id="my-tickets">
        <ul class="dashboard__list party">
            <li class="do-not-print print"><a class=""><?= Html::submitButton('Print', ['class' => 'button']) ?></a></li>
                <li class="ticket" style="">
                    <div>
                        <h2><center><b><?php echo $ticket->detail->title?></center></b></h2>
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
                            <a style="float: left" class="left" href="/member/qt<?php echo $ticket->user->id?>">
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
            <li class="do-not-print"><a class="print"><?= Html::submitButton('Print', ['class' => 'button']) ?></a></li>
        </ul>
    </div>
<?php endif;?>
</body>
</html>