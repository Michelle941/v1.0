<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Url;
use app\models\User;

$this->title = 'Members';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'last_name',
            'email',
            'rank',
            [
                'class'     => DataColumn::className(),
                'attribute' => 'premium_status',
                'format'    => ['boolean'],
                'filter'    => [0 => 'No', 1 => 'Yes']
            ],
            'premium_type',
            [
                'class'     => DataColumn::className(),
                'attribute' => 'role',
                'format'    => ['html'],
                'value'     => function($data){
                    return implode('<br>',ArrayHelper::map(Yii::$app->authManager->getRolesByUser($data->getPrimaryKey()), 'description', 'description'));
                },
                'filter'    => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description')
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{reset}&nbsp;&nbsp;{delete}',
                'buttons' =>
                [
                    'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-zoom-in"></span>', Url::toRoute(['view-user', 'id' => $model->id]), [
                                        'title' => Yii::t('yii', 'View'),
                                        'data-pjax' => '0',
                                    ]); },

                    'update' => function ($url, $model) {
                                if($model->status > User::STATUS_DELETED)
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['update-user', 'id' => $model->id]), [
                                    'title' => Yii::t('yii', 'Update'),
                                    'data-pjax' => '0',
                                ]); },
                    'reset' => function ($url, $model) {
                            if($model->status > User::STATUS_DELETED)
                                return Html::a('<span class="fa fa-key"></span>', Url::toRoute(['reset-password', 'id' => $model->id]), [
                                        'title' => Yii::t('yii', 'Reset password'),
                                        'data-pjax' => '0',
                                    ]); },
                    'delete' => function ($url, $model) {
                            if($model->status > User::STATUS_DELETED)
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete-user','id' => $model->id]), [
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

</div>
