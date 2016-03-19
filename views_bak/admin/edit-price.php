<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Sale;
use yii\grid\GridView;
use yii\grid\DataColumn;

$this->title = 'Edit price';
$this->params['breadcrumbs'][] = ['label' => 'Party manage', 'url' => ['party']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">

    <h1><?= Html::encode($party->title) ?></h1>

    <p>
        <?= Html::a('Add new sale', Url::to(['add-sale', 'id' => $party->id]), ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    foreach($sale as $s)
    {
        ?>

            <div class="box box-primary">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-11">
                            <h3><?=Sale::getSaleType($s->sale_type);?></h3>
                            <?=$s->started_at;?> - <?=$s->finished_at;?><br>
                        </div>
                        <div class="col-md-1">
                            <?php
                            //TODO: confirm delete
                            echo \yii\helpers\Html::button('X', [
                                'class' => 'btn btn-default btn-sm pull-right',
                                'title' => 'Delete',
                                'data-widget' => "remove",
                                'onclick'=> "
                                    $.get('".Url::to(['delete-sale', 'id' => $s->id])."', '');
                                    return false;",
                            ]);
                        ?>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
            <div class="col-md-4">
                Thumbnail<br>
                <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$s->thumbnail;?>" height="50px;"><br>
            </div>
            <div class="col-md-4">
                Mini flayer<br>
                <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$s->mini_flyer;?>" height="50px"><br>
            </div>
            <div class="col-md-4">
                Flayer Top<br>
                <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$s->flyer_top;?>" height="50px"><br>
            </div>
            <div class="col-md-4">
                Flayer Bottom<br>
                <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$s->flyer_bottom;?>" height="50px"><br>
            </div>
            <div class="col-md-4">
            Message Banner<br>
                <img src="<?=Yii::$app->params['flayerPath'];?>/<?=$s->message_banner;?>" height="50px"><br>
            </div>
            <div class="col-md-12">
                <h4>Tickets</h4>
                <?= Html::a('Add new', Url::to(['add-ticket', 'id' => $party->id, 'saleID' => $s->id]), ['class' => 'btn btn-success']) ?>
                <?php
                $dataProvider = new \yii\data\ArrayDataProvider(['allModels' => $s->ticket]);
                ?>
                <?php \yii\widgets\Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'title',
                        'description:ntext',
                        'quantity',
                        'price',
                        [
                            'class'     => DataColumn::className(),
                            'attribute' => 'image',
                            'format'    => 'html',
                            'value'     => function($data) { return "<img src='".Yii::$app->params['flayerPath']."/{$data->image}' width=160 height=160>"; }
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                         'template' => '{delete}',
                         'urlCreator'=>function($action, $model) use ($party) {
                                   return ['delete-ticket-type','id'=>$model->id, 'partyID' => $party->id];
                         },
                        ],
                    ],
                ]); ?>
                <?php \yii\widgets\Pjax::end(); ?>
            </div>
        </div>
                </div></div><br>
        <?php
    }
    ?>

</div>