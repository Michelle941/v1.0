
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<style>
    .messages{min-width: 800px;}
    li.message{margin: 15px; clear: both;}
    li.message .title{text-align: center; color: #808080;  font-size: 8px}
    li.message div.body{
        border: 1px solid #808080;
        margin: 10px;
        border-radius: 18px;
        padding: 10px;
        background-color: #F7F7F7;
        min-height:30px;
    }
    li.message div.body.left{text-align: left;width: 75%;}
    li.message div.body a{float: left;margin-right: 10px;}
    li.message div.body.right{text-align: right; float: right;width: 75%;}
    li.message div.body.right a{float: right;margin-left: 10px}
    li.message div.body .text{padding: 0 10px; text-align: justify; text-justify: inter-word;}
    li.message div.body .text.bold{font-weight: bolder;}
    li.message.last div.body{
        background-color: #ffffff;
        border: none;
        padding: 0px;
        margin-right:30px;
    }
    li.message.last div.body textarea{
        background-color: #ffffff;
        border: 1px solid #808080;
        border-radius: 18px;
        padding: 10px;
        width: 100%;

    }
</style>

<div class="message-form">
	<div class="form">
    <?php $form = ActiveForm::begin([
	    'id' => 'message-form',
	    'fieldConfig' => [
		    'template' => '{input}{error}'
	    ],
    ]); ?>
	<h2 style="text-align: center" class="popup__title">
    Send message to <?=$userTo->name;?>
	</h2>
        <div class="messages">
            <ul>
                <?php foreach(\app\models\Message::_getMessages($userTo->id, $user->id) as $msg): ?>
                <li class="message">
                    <div class="body <?php echo $msg->user_to === $user->id ? 'left':'right'?>">
                        <?php if($msg->user_to === $user->id):?>
                            <a href="/member/qt<?php echo $msg->user_from?>">
                                <img src="/upload/30x30_square<?php echo $msg->sender->avatar?>" alt="" width="30" height="30">
                            </a>
                            <div class="text <?php echo $msg->read_at ? '' : 'bold'?>">
                                <?php if(!Yii::$app->user->can('premium')): ?>
                                    <?php echo Yii::$app->controller->renderPartial('/notice/buy_premium');?>
                                <?php else:?>
                                    <?= $msg->getText();?>
                                    <?php if(!$msg->read_at){$msg->read_at = time();$msg->save();}?>
                                <?php endif;?>
                            </div>
                        <?php else:?>
                            <a href="/member/qt<?php echo $user->id?>">
                                <img src="/upload/30x30_square<?php echo $user->avatar?>" alt="" width="30" height="30">
                            </a>
                            <div  class="text">
                                <?= $msg->getText();?>
                            </div>
                        <?php endif?>
                    </div>
                </li>
                <?php endforeach;?>
                <li class="message last">
                    <div class="body" style="font-family: 'Questrial', sans-serif;">
                        <?= $form->field($model, 'text')->textarea(['rows' => 6, 'placeholder' => 'Say something nice', 'style' => 'font-family: \'Questrial\', sans-serif; font-size: inherit;'])->label(false) ?>
                    </div>
		</li>
                    <div class="body"><?= Html::submitButton('Send', ['class' => 'button-follow']) ?></div>
            </ul>
        </div>
    <?php ActiveForm::end(); ?>

</div>
<script>
// get the form id and set the event
$('#message-form :submit').on('click', function(e){
e.preventDefault();
submitFormMoreTime($(this.form));
});
</script>
