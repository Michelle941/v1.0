<style>
    .buy-tickets__title{margin: 10px; width: 6%; margin-left: 0px;}
    .buy-tickets__title.ticket-title{width: 50%;}
    .buy-tickets__title.flash{width: 15%;}
    .buy-tickets__title.flash-price{width: 11%;}
    .form .input__number .input__number-control.sold-out{ width: 80px;height: 10px;margin: 5px;}
    p.error{display: none; color: #ff0000;text-align: center;margin: 10px;}
</style>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<div class="buy-tickets">
    <div class="form">
        <?php $form = ActiveForm::begin([
            'action' => yii\helpers\Url::to(['/site/buy-ticket', 'partyID' => $partyID]),
            'method' => 'get'
        ]); ?>

            <div class="buy-tickets__form">
                <div class="buy-tickets__inner">
                    <h1 class="popup__title"><?php echo $sale->top_text?></h1>
                    <?php if(isset($sale->ticket)): ?>
                        <?php foreach($sale->ticket as $ticket):
                            $available = $ticket->countAvailable(); ?>
                            <div class="buy-tickets__item">
                                <div class="input__number">
                                    <?php if($available):?>
                                    <span class="input__number-control input__number-control--minus"></span>
                                    <span class="input__number-control input__number-control--plus"></span>
                                    <input class="count" type="number" value="0" min="0" name="ticket[<?=$ticket->id;?>]" id="buy-50">
                                <?php else:?>
                                        <span class="input__number-control sold-out">SOLD OUT</span>
                                <?endif;?>
                                </div>
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
                                <p>
                                    <?=$ticket->description;?>
                                </p>
                            </div>
                        <?php endforeach;?>
                    <?php endif; ?>
                    <br><br>
                    <h3 class="popup__title"><?php echo $sale->bottom_text?></h3>
                    <p><?php echo $sale->bottom_text_8?></p>
                </div>
            </div>
            <p class="error red hide">Please select ticket quantity</p>
            <button  type="submit" class="button buy-tickets__button">Buy tickets</button>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$js = <<<JS
$( "form" ).submit(function( event ) {
  var total_price = 0;

  $('input.count').each(function() {
   total_price+= parseInt($(this).val());
  });
  if(total_price <1){
    event.preventDefault();
    $(this).find('p.error').show();
    return false;
  }
  return true;

});
JS;
$this->registerJs($js);
?>