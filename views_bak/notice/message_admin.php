<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?=$message->text;?>

<br><br>
<?php $form = ActiveForm::begin(); ?>
<?= Html::textarea('answer', null, [
    'rows' => 3,
    'cols' => 100
]) ?>
<?=Html::hiddenInput('re_id', $message->id);?>
<?=Html::hiddenInput('user_from', $message->user_from);?>
<br>
<?= Html::submitButton('Send answer') ?>
<?php ActiveForm::end(); ?>