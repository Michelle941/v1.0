<div class="row">
    <div class="col-lg-3">Ticket type</div>
    <div class="col-lg-3">Count</div>
    <div class="col-lg-3">Price</div>
    <div class="col-lg-3">Total price</div>
</div>
<?php
foreach($order as $ord)
{
    ?>
    <div class="row">
        <div class="col-lg-3"><?=$ord['type'];?></div>
        <div class="col-lg-3"><?=$ord['kol'];?></div>
        <div class="col-lg-3"><?=$ord['price'];?></div>
        <div class="col-lg-3"><?=round($ord['price']*$ord['kol'], 2);?></div>
    </div>
    <?php
}
?>

<br><br><br>
<form method="post" action="<?=$post_url;?>">
    <?=$hidden_fields;?>
    <fieldset>
        <div>
            <label>Credit Card Number</label>
            <input type="text" class="text" size="15" name="x_card_num" value="">
        </div>
        <div>
            <label>Exp.</label>
            <input type="text" class="text" size="4" name="x_exp_date" value="">
        </div>
        <div>
            <label>CCV</label>
            <input type="text" class="text" size="4" name="x_card_code" value="">
        </div>
    </fieldset>
    <fieldset>
        <div>
            <label>First Name</label>
            <input type="text" class="text" size="15" name="x_first_name" value="">
        </div>
        <div>
            <label>Last Name</label>
            <input type="text" class="text" size="14" name="x_last_name" value="">
        </div>
    </fieldset>
    <fieldset>
        <div>
            <label>Address</label>
            <input type="text" class="text" size="26" name="x_address" value="">
        </div>
        <div>
            <label>City</label>
            <input type="text" class="text" size="15" name="x_city" value="">
        </div>
    </fieldset>
    <fieldset>
        <div>
            <label>State</label>
            <input type="text" class="text" size="4" name="x_state" value="">
        </div>
        <div>
            <label>Zip Code</label>
            <input type="text" class="text" size="9" name="x_zip" value="">
        </div>
        <div>
            <label>Country</label>
            <input type="text" class="text" size="22" name="x_country" value="">
        </div>
        <div>
            <label>Email</label>
            <input type="text" class="text" size="22" name="x_email" value="">
        </div>
    </fieldset>
    <input type="submit" value="BUY" class="submit buy">
</form>