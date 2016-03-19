<?php

use yii\grid\GridView;
use yii\grid\DataColumn;
?>
<div class="news-index">

    <div class="links-form">
        <div class="box box-primary">
            <div class="box-header">
                <h1>My tickets</h1>
            </div>

            <div class="box-body">

                <div class="row">
                    <?php
                    // все теже самые данные доступны в виде массива объектов в массиве $tickets
                    ?>
                    <?= GridView::widget([
                        'dataProvider' => $data,
                        'class' => 'pure-table',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'class'     => DataColumn::className(),
                                'attribute' => 'party',
                                'format' => 'html',
                                'value' =>  function($data){
                                    return "<a href='".\yii\helpers\Url::to(['/site/party', 'id' => $data->party->url])."'>".$data->party->title."</a>";
                                }
                            ],
                            'bought_at:datetime',
                            [
                                'class'     => DataColumn::className(),
                                'attribute' => 'price',
                                'value' =>  function($data){
                                    return $data->detail->price ;
                                }
                            ],
                            [
                                'class'     => DataColumn::className(),
                                'attribute' => 'status',
                                'filter' => [0 => 'Canceled', 1=> 'Active'],
                                'value' =>  function($data){
                                    return $data->status ? 'Active' : 'Canceled';
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
