<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use dosamigos\fileinput\FileInput;
?>

<?php $form = ActiveForm::begin(
    ['options' => ['enctype'=>'multipart/form-data'],
        'action' => \yii\helpers\Url::to(['/admin/update-party/', 'id' => $model->id, 'tab' => 4])
    ]
); ?>
    <div class="row">
        <div class="col-md-6">
            Thumbnail:
            <?php
            echo FileInput::widget([
                'model' => $model,
                'attribute' => 'thumbnail',
                'thumbnail' => '<img src="'.Yii::$app->params['flayerPath'].'/'.$model->thumbnail.'">',
                'style' => FileInput::STYLE_IMAGE
            ]);
            ?>
        </div>
        <div class="col-md-6">
            Mini flayer:
            <?php
            echo FileInput::widget([
                'model' => $model,
                'attribute' => 'mini_flyer',
                'thumbnail' => '<img src="'.Yii::$app->params['flayerPath'].'/'.$model->mini_flyer.'">',
                'style' => FileInput::STYLE_IMAGE
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            Flayer Top:
            <?php
            echo FileInput::widget([
                'model' => $model,
                'attribute' => 'flyer_top',
                'thumbnail' => '<img src="'.Yii::$app->params['flayerPath'].'/'.$model->flyer_top.'">',
                'style' => FileInput::STYLE_IMAGE
            ]);
            ?>
        </div>
        <div class="col-md-6">
            Message Banner:
            <?php
            echo FileInput::widget([
                'model' => $model,
                'attribute' => 'message_banner',
                'thumbnail' => '<img src="'.Yii::$app->params['flayerPath'].'/'.$model->message_banner.'">',
                'style' => FileInput::STYLE_IMAGE
            ]);
            ?>
        </div>
	<div class="col-md-6">
            Party First:
            <?php
            echo FileInput::widget([
                'model' => $model,
                'attribute' => 'party_first',
                'thumbnail' => '<img src="'.Yii::$app->params['flayerPath'].'/'.$model->party_first.'">',
                'style' => FileInput::STYLE_IMAGE
            ]);
            ?>
        </div>
        <div class="col-md-6">
            Party Last:
            <?php
            echo FileInput::widget([
                'model' => $model,
                'attribute' => 'party_last',
                'thumbnail' => '<img src="'.Yii::$app->params['flayerPath'].'/'.$model->party_last.'">',
                'style' => FileInput::STYLE_IMAGE
            ]);
            ?>
        </div>
        <div class="col-md-6">
            Party More:
            <?php
            echo FileInput::widget([
                'model' => $model,
                'attribute' => 'party_more',
                'thumbnail' => '<img src="'.Yii::$app->params['flayerPath'].'/'.$model->party_more.'">',
                'style' => FileInput::STYLE_IMAGE
            ]);
            ?>
        </div>



    </div>
    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
