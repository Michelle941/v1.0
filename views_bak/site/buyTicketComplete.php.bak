<?php
use yii\widgets\ActiveForm;
?>

<style>
    .left{ float: left;}
    .center{text-align: center}
    .member-title .popup__title{font-size: 18px;margin-top:30px;}
    .button{height: 50px;}

    </style>
<div class="form">
    <h2 class="popup__title center">YAY!<br> we can't wait to party with you</h2><br>
    <p style="font-size: 15px" >We sent the tickets to these emails:</p><br>
    <ul>
        <?php foreach($emails as $email):?>
        <li><?php echo $email?></li><br>
        <?php endforeach;?>
    </ul>
    <br><br>
    <p>If you do not receive the tickets within 3 minutes, Please check your spam folder.<br> If you still cannot find the tickets, contact us at holla@941socialclub.com</p>
    <br><br><br><br><br><br><br>
    <h2 class="popup__title center">Please tell us who you bought tickets for so we can send the ticket to their 941 Social Club profile</h2><br><br>
    <div class="form">
        <?php $form = ActiveForm::begin([
            'action' => yii\helpers\Url::to(['/site/complete-ticket']),
            'method' => 'post'
        ]); ?>
            <ul>
            <?php foreach($tickets as $ticket):if(empty($ticket['users'])) continue;?>
                <li class="member-title"><h2 class="popup__title"><?php echo @$ticket['title']?></h2><br></li>
                <li>
                    <ul>
                        <?php foreach($ticket['users'] as $user):?>
                            <li class="members__item">
                                <label for="radio_<?=$ticket['id'].$user->id;?>">
                                    <img src="/upload/160x160_square<?=$user->avatar;?>"><br>
                                    <?=$user->name;?>
                                </label>
                                <input id="radio_<?=$ticket['id'].$user->id;?>" type="radio" name="ticket[<?=$ticket['id']?>]" value="<?=$user->id;?>">
                            </li>
                        <?php endforeach;?>
                    </ul>
                </li>
            <?php endforeach;?>
            </ul>
        <button type="submit" class="button buy-tickets__button">Done</button>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<br><br><br><br><br>

