<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Edit user';
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['user']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="links-create">

    <h1><?= $model->name.' '.$model->last_name; ?></h1>

    <div class="links-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'last_name')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

        <?= $form->field($model, 'rank')->textInput(['maxlength' => 255]) ?>

        <div class="form-group">
            <?= Html::label('Role'); ?>
            <?= Html::checkboxList('roles', $user_permit, $roles, ['separator' => '<br>']); ?>
        </div>


        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>
