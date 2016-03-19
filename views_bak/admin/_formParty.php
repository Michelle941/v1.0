<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
?>

<div class="pages-form">
    <?php $form = ActiveForm::begin(
        [
            'action' => Url::to(['/admin/update-party/', 'id' => $model->id])
        ]
    ); ?>
    <div class="row">
        <div class="col-md-8">

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'password')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'manager_password')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'ticket_prefix')->textInput(['maxlength' => 10]) ?>

    <?=implode('<br>', $model->getErrors('description'));?>
    <?= $form->field($model, 'description')->textarea(['rows' => 3, 'maxlength' => 255]); ?>
    <?= $form->field($model, 'location')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'rank')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'tags')->textInput(['maxlength' => 255]) ?>
    <?= $form->field($model, 'account_note')->textarea(['rows' => 3]); ?>
    </div>
    <div class="col-md-3">
        <?php if (!$model->isNewRecord)
        {
            echo "<a href='".Url::to(['/site/party', 'id' => $model->url, 'preview' => 1])."' target='_blank'>Preview</a>";
            if($model->status == 0)
            {
                echo "<div class='callout callout-danger'>
                <h4>Status: preview</h4>";
                if(Yii::$app->user->can('changeStatus'))
                    echo "<a href='".Url::to(['publish-party', 'id' => $model->id])."'>Change status to publish</a>";
                else echo "You haven't permission to change status";
                echo "</div>";
            }
            else{
                echo "<div class='callout callout-info'>
                <h4>Status: publish</h4>
                <a href='".Url::to(['unpublish-party', 'id' => $model->id])."'>Change status to preview</a>
                </div>";
            }
        }
        ?>
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

        <?php if (!$model->isNewRecord)
        {
           ?>
           <div class="row">
               <h2>Staff</h2>
               <div class="col-lg-6">
                   <?= Html::button(
                       'add',
                       ['value' => Url::to(['attach-staff', 'partyID'=> $model->id]),
                           'class' => 'btn btn-success modalButton'
                       ])
                   ?>
               </div>
               <div id="attach-staff">
               <?php
               echo $this->render('_staff2party', ['staff' => $staff]);
               ?>
               </div>
           </div>
           <?php
        }
        ?>
    </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Next step': 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if (!$model->isNewRecord)
    {
        ?>

    <h2>Contact info</h2>
    <p>
        <?= Html::button(
            'create',
            ['value' => Url::to(['add-contact', 'partyID'=> $model->id]),
             'class' => 'btn btn-success modalButton'
            ]) ?>
    </p>
    <div class="row" id="contact">
                <?php
                echo $this->render('_contact', ['contact' => $contact, 'id' => $model->id]);
                ?>
    </div>
     <?php
    }
    ?>
</div>