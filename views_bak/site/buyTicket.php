
<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<style>
    fieldset {margin: 40px 10px; height: 130px}
    .form-group:first-child:nth-last-child(2),
    .form-group:first-child:nth-last-child(2) ~ .form-group  {
        width: 50%;
        float: left;
    }
    .form fieldset div input{background-color: transparent !important;}
    h3.popup__title{
        font-size: 18px;
        text-align: left;
    }
    .button{height: 50px;}
</style>
<div class="form" style="text-align: center; width: 800px;margin:0 auto">
    <h2 class="popup__title">Please complete guest information for each ticket</h2>

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => '{input}{error}'
        ]
    ]); ?>
<?php foreach($models as $key => $model):?>
    <fieldset style="">
        <h3 class="popup__title left"><?php echo $model['data']['ticket_title']?></h3>
        <div class="form__row">
            <?= $form->field($model, "[$key]name")->textInput(array('placeholder' => 'First Name', 'required' => 'required', 'class' => 'name'))->label(false); ?>
            <?= $form->field($model, "[$key]lastname")->textInput(array('placeholder' => 'Last Name', 'required' => 'required',  'class' => 'lastname'))->label(false); ?>
        </div>
        <div class="form__row">
            <?= $form->field($model, "[$key]email")->textInput(array('placeholder' => 'Email', 'required' => 'required'))->label(false); ?>
            <?= $form->field($model, "[$key]instagram")->textInput(array('placeholder' => 'Instagram'))->label(false); ?>
        </div>
    </fieldset>
<?php endforeach;?>
    <input type="submit" value="Continue" class="button">
    <?php ActiveForm::end(); ?>
</div>
<br><br><br><br><br>