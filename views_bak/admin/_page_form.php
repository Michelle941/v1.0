<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use developeruz\tinymce\TinyMce;
?>

<div class="pages-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>"multipart/form-data"]]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

    <?= TinyMce::widget( [
            'model' => $model,
            'attribute' => 'text',
            'options' => ['rows' => 6]
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
