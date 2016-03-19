<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use developeruz\tinymce\TinyMce;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;

$this->title = 'New party';
$this->params['breadcrumbs'][] = ['label' => 'Party manage', 'url' => ['party']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-create">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-8">

            <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'password')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'manager_password')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'ticket_prefix')->textInput(['maxlength' => 10]) ?>


            <?=implode('<br>', $model->getErrors('description'));?>
            <?= $form->field($model, 'description')->textarea(['rows' => 3]); ?>
            <?= $form->field($model, 'location')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'rank')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'tags')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'account_note')->textarea(['rows' => 3]); ?>

        </div>
        <div class="col-md-3">
            <div>
                <?php
                echo $form->field($model, 'started_at')->widget(DateTimePicker::className(),[
                    'type' => DateTimePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd hh:ii'
                    ]
                ]);
                ?>
            </div>
            <div>
                <?php
                echo $form->field($model, 'finished_at')->widget(DateTimePicker::className(),[
                    'type' => DateTimePicker::TYPE_INPUT,
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd hh:ii'
                    ]
                ]);
                ?>
            </div>

            <?= $form->field($model, 'allow2sharing')->checkbox();?>
            <?= $form->field($model, 'allow2add_photo')->checkbox(); ?>
            <?= $form->field($model, 'highlight')->checkbox(); ?>
        </div></div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Next step': 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
