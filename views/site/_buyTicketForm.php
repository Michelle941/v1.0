<style>
    .buy-tickets__title{margin: 10px; width: 6%; margin-left: 0px;}
    .buy-tickets__title.ticket-title{width: 50%;}
    .buy-tickets__title.flash{width: 15%;}
    .buy-tickets__title.flash-price{width: 11%;}
    .form .input__number .input__number-control.sold-out{ width: 80px;height: 10px;margin: 5px;}
    p.error{display: none; color: #ff0000;text-align: center;margin: 10px;}
    .buy-tickets{ display:none }
    .hidden-div{ display:none; margin-bottom:0;}
</style>
<button onclick="getElementById('hidden-div').style.display = 'block'" style="margin-bottom: 1px"> Buy Tickets Now </button>

<div class="hidden-div" id="hidden-div" style="height: 100%;"><?php echo $eventbrite;?></div>
<br><br><br><br><br>
