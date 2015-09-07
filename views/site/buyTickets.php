<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<style>
    .ticket-info{margin-bottom: 50px;}
    .ticket-info li{margin: 10px; 0px; font-size: 17px; clear: both; font-weight:normal;}
    .ticket-info li .title{float: left; text-align: left; margin-right: 20px;}
    .ticket-info li .price{float: left; text-align: left;}
    .button{height: 50px;}
    a.terms{text-decoration: underline;}

</style>
<div class="form" style="text-align: center; width: 800px;margin: 0 auto">
    <h2 class="popup__title">Payment information</h2>
    <ul class="ticket-info popup__title">
        <?php $total = 0; foreach($tickets as $ticket): $total+=$ticket['data']['ticket']['price']?>
        <li>
            <span class="title"><?php echo $ticket['data']['ticket_title']?> </span>
            <span class="price">$<?php echo number_format($ticket['data']['ticket']['price'], 2, '.', '');?> </span>
        </li>
        <?php endforeach;?>
        <li>
            <span class="title"><b>Total </b></span>
            <span class="price"><b>$<?php echo number_format($total, 2, '.', '')?></b></span>
        </li>
    </ul>
    <div style="clear: both"></div>
    <?php
    $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => '{input}{error}'
        ]
    ]); ?>

        <fieldset>
            <?php if($errorMessage):?>
                <div class="form__row">
                    <p style="color: red"><?php echo $errorMessage?></p>
                </div>
            <?php endif;?>
            <div class="form__row">
                <input placeholder="First Name" type="text" class="text" size="15" name="first_name" value="<?php echo @$_POST['first_name']?>">
            </div>
            <div class="form__row">
                <input placeholder="Last Name" type="text" class="text" size="14" name="last_name" value="<?php echo @$_POST['last_name']?>">
            </div>
            <div class="form__row">
                <input placeholder="Email" type="text" class="text" size="22" name="email" value="<?php echo @$_POST['email']?>">
            </div>
        </fieldset>
        <fieldset>
            <div  class="form__row">
                <input placeholder="Credit Card Number" style="width:69%" type="text" class="text" size="15" name="card_num" value="">
                <input placeholder="Exp MM/YYYY" type="text"  style="width:15%" class="text" size="4" name="exp_date" value="">
                <input placeholder="CCV" type="text"  style="width:15%" class="text" size="4" name="card_code" value="">
            </div>
        </fieldset>
        <fieldset>
            <div class="form__row">
                <input placeholder="Address" type="text" class="text" size="26" name="address" value="<?php echo @$_POST['address']?>">
            </div>
            <div class="form__row">
                <input style="width: 69%" placeholder="City" type="text" class="text" size="15" name="city" value="<?php echo @$_POST['city']?>">
                <input style="width: 15%" placeholder="State" type="text" class="text" size="4" name="state" value="<?php echo @$_POST['state']?>">
                <input style="width: 15%" placeholder="Zip Code" type="text" class="text" size="9" name="zip" value="<?php echo @$_POST['zip']?>">
            </div>
        </fieldset>
        <input type="submit" value="Buy Tickets" class="button submit buy">
        <br>
        <br>
        <p>By clicking Buy Tickets, i agree to one-time payment of $<?php echo number_format($total, 2, '.', '')?> in accordance with the <a class="terms" href="" target="_blank">TERMS OF USE</a></p>
    <?php ActiveForm::end(); ?>
</div>
<?php
$js = <<<JS
var width = Math.max.apply(Math, $('.ticket-info li .title').map(function(){ return $(this).width(); }).get());
$('.ticket-info li .title').css('width', width);
JS;
$this->registerJs($js);
?>