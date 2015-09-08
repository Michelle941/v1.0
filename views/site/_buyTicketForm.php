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