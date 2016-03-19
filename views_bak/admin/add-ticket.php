<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use dosamigos\fileinput\FileInput;
?>
<div class="ticket-form">

    <?php $form = ActiveForm::begin(
       ['options' => ['enctype'=>'multipart/form-data'],
        'id' => 'ticket-form',
         'action' => \yii\helpers\Url::to(['admin/add-ticket' ,'id' => $party_id, 'saleID' => $model->sale_id, 'tab'=> $tab])
       ]
    ); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => 19]) ?>
    <?php if($tab  == 2):?>
        <?= $form->field($model, 'actual_price')->textInput(['maxlength' => 19]) ?>
    <?php endif;?>

    <?php
    echo implode('<br>', $model->getErrors('image'));

    echo FileInput::widget([
        'model' => $model,
        'attribute' => 'image',
        'thumbnail' => '<img src="'.Yii::$app->params['flayerPath'].'/'.$model->image.'">',
        'style' => FileInput::STYLE_IMAGE
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>