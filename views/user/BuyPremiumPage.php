<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="form" style="text-align: center; width: 800px;margin: 0 auto">
    <?php if($type === 'monthly'):?>

        <h2 class="popup__title">Members have more fun</h2>
        <p>Please complete this payment information</p>
        <p>for your $<?php echo $amount?> <?php echo $type?> premium membership</p>
    <?php else:?>
        <h2 class="popup__title">Brilliant!</h2>
        <p>Please complete this payment information</p>
        <p>for your $<?php echo $amount?> <?php echo $type?> premium membership</p>

    <?php endif;?>

    </br></br>

    <?php $form = ActiveForm::begin([
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
                <input disabled placeholder="Email" type="text" class="text" size="22" name="email" value="<?php echo $user->email?>">
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
        <input type="submit" value="Upgrade Membership" class="button submit buy">
    <?php ActiveForm::end(); ?>
    </br></br>
    <?php if($type === 'monthly'):?>
        <p>By clicking upgrade membership, i agree to initial payment of $<?php echo $amount?></p>
        <p>and recurring monthly payments of $<?php echo $amount?> beginning the first day of</p>
        <p>month 2 until i cancel in accordance with the <a href="" target="_blank">TERMS OF USE</a></p>
        <?php else:?>
        <p>By clicking upgrade membership, i agree to initial payment of $<?php echo $amount?></p>
        <p>and recurring annual payments of $<?php echo $amount?> beginning the first day of</p>
        <p>year 2 until i cancel in accordance with the <a href="" target="_blank">TERMS OF USE</a></p>
    <?php endif;?>
</div>