<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;


$this->title = 'Manage content page';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-index">

    <p>
        <?= Html::a('Add new', ['add-page'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'url',
            [
                'class'     => DataColumn::className(),
                'attribute' => 'text',
                'format'    => 'html',
                'value'     => function($data) { return \yii\helpers\StringHelper::truncate($data->text, 100); }
            ],
            ['class' => 'app\components\ButtonUpdateDelete',
                'updateAction' => '/admin/update-page',
                'deleteAction' => '/admin/delete-page'
            ],
        ],
    ]); ?>

</div>