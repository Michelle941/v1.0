<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use dosamigos\fileinput\FileInput;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\DataColumn;
?>
<div class="sale-form">

    <?php $form = ActiveForm::begin(
       ['options' => ['enctype'=>'multipart/form-data'],
        'action' => \yii\helpers\Url::to(['/admin/update-party/', 'id' => $model->party_id, 'tab' => $tab])
       ]
    ); ?>

    <?= $form->field($model, 'started_at')->widget(DateTimePicker::className(),[
            'type' => DateTimePicker::TYPE_INPUT,
            'options' => ['id' => Yii::$app->security->generateRandomString(5)],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd hh:ii'
            ]
        ]); ?>
    
    <?= $form->field($model, 'eventbrite_html')->textarea(['rows' => 10]) ?>
    <?= $form->field($model, 'top_text')->textarea(['rows' => 2]) ?>
    <?= $form->field($model, 'bottom_text')->textarea(['rows' => 2]) ?>
    <?= $form->field($model, 'bottom_text_8')->textarea(['rows' => 2]) ?>

    <?= $form->field($model, 'finished_at')->widget(DateTimePicker::className(),[
            'type' => DateTimePicker::TYPE_INPUT,
            'options' => ['id' => Yii::$app->security->generateRandomString(5)],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd hh:ii'
            ]
        ]); ?>

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
    Flayer Bottom:
    <?php
    echo FileInput::widget([
            'model' => $model,
            'attribute' => 'flyer_bottom',
            'thumbnail' => '<img src="'.Yii::$app->params['flayerPath'].'/'.$model->flyer_bottom.'">',
            'style' => FileInput::STYLE_IMAGE
        ]);
    ?>
        </div>
    </div>
    <div class="row">
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
    </div>
    <div class="row">
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

    <div class="row">
    <?php
    if(!$model->isNewRecord) {
        ?>
        <div class="col-md-12">
            <h4>Tickets</h4>
            <?= Html::button(
                'Add new',
                ['value' => Url::to(['add-ticket', 'id' => $model->party_id, 'saleID' => $model->id, 'tab' => $tab]),
                    'class' => 'btn btn-success modalButton'
                ]) ?>
            <?php
            $dataProvider = new \yii\data\ArrayDataProvider(['allModels' => $model->ticket]);
            $partyID = $model->party_id;
            ?>
            <?php \yii\widgets\Pjax::begin(); ?>
            <?php $widget_config = [
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'title',
                    'description:ntext',
                    'quantity',
                    'price',
                    'actual_price',
                    [
                        'class' => DataColumn::className(),
                        'attribute' => 'image',
                        'format' => 'html',
                        'value' => function ($data) {
                            return "<img src='" . Yii::$app->params['flayerPath'] . "/{$data->image}' width=160 height=160>";
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                        'urlCreator' => function ($action, $model) use ($partyID, $tab){
                            return ['delete-ticket-type', 'id' => $model->id, 'partyID' => $partyID, 'tab' => $tab];
                        },
                    ],
                ],
            ]; ?>
            <?php echo GridView::widget($widget_config);?>
            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    <?php
    }
    ?>
    </div>
</div>
