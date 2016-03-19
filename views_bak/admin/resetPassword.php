<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\password\PasswordInput;


$this->title = 'Reset password';
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="links-create">

    <h1><?php echo Html::encode($this->title)." for ".$model->name.' '.$model->last_name; ?></h1>

    <div class="links-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'password')->widget(PasswordInput::classname());?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
