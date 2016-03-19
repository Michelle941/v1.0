<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Url;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class'     => DataColumn::className(),
            'attribute' => 'party_id',
            'value' =>  function($data){
                return $data->party->title;
            }
        ],
        [
            'class'     => DataColumn::className(),
            'attribute' => 'user_id',
            'value' =>  function($data){
                return $data->user->name.' '.$data->user->last_name;
            }
        ],
        'bought_at:datetime',
        'hash',
        [
            'class'     => DataColumn::className(),
            'attribute' => 'status',
            'filter' => [0 => 'Canceled', 1=> 'Active'],
            'value' =>  function($data){
                return $data->status ? 'Active' : 'Canceled';
            }
        ],
        ['class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' =>
                [
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', Url::toRoute(['admin/cancel-ticket','id' => $model->id]), [
                            'title' => Yii::t('yii', 'Cancel'),
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to cancel this ticket?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                    }
                ]
        ],
    ],
]); ?>