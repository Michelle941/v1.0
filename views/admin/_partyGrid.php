<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{pager}\n{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'rank',
            'url',
            'highlight',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{delete}',
                'buttons' =>
                    [
                        'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['/admin/update-party', 'id' => $model->id]), [
                                            'title' => Yii::t('yii', 'Update'),
                                            'data-pjax' => '0',
                                        ]); },
                        'delete' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['admin/delete-party','id' => $model->id]), [
                                            'title' => Yii::t('yii', 'Delete'),
                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                        ]);
                            }
                    ]
            ],
        ],
    ]); ?>