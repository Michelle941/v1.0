<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Url;
?>
<div class="row">
    <div class="pages-index col-md-10">
        <h3>
            <?php echo $party->title?> <br>
            <?php echo date('M d, Y', strtotime($party->started_at))?>
        </h3>
        <h3>Guest list</h3>
        <?php $columns = [
            'dataProvider' => $model->dp($partyId),
            'class' => 'pure-table',
            'columns' => [
                [
                    'attribute' => 'ticket_number_seq',
                    'format' => 'text',
                    'label' => 'Ticket Number',
                ],
                [
                    'attribute' => 'name',
                    'format' => 'text',
                    'label' => 'First Name',
                ],
                [
                    'attribute' => 'lastname',
                    'format' => 'text',
                    'label' => 'Last Name',
                ],
                'email',
                'instagram',
                [
                    'attribute' => 'detail.title',
                    'format' => 'text',
                    'label' => 'Type',
                ]
            ],
        ];
        if($adminType ==='manager'){
            $columns['columns'][] = [
                'attribute' => 'detail.price',
                'format' => 'text',
                'label' => 'Price',
                'value' =>function($data){return number_format($data->detail->price, 2, '.', ',');}
            ];
            $columns['columns'][] = [
                'class'     => DataColumn::className(),
                'attribute' => 'checked',
                'label' => 'Action',
                'format'    => 'html',
                'value'     => function($data) {
                    if($data->checked == 1){
                        return Html::a(Yii::t('yii', 'Check Out'), Url::toRoute(['/eventmanagement/checkout/', 'id' => $data->id]), [
                            'title' => Yii::t('yii', 'Check Out'),
                            'data-pjax' => '0',
                        ]);
                    }
                    return Html::a(Yii::t('yii', 'Check In'), Url::toRoute(['/eventmanagement/checkin/', 'id' => $data->id]), [
                        'title' => Yii::t('yii', 'Check In'),
                        'data-pjax' => '0',
                    ]);
                }
            ];
        }
        else{
            $columns['columns'][] = [
                'class'     => DataColumn::className(),
                'attribute' => 'checked',
                'label' => 'Action',
                'format'    => 'html',
                'value'     => function($data) {
                    if($data->checked != 1){
                        return Html::a(Yii::t('yii', 'Check In'), Url::toRoute(['/eventmanagement/checkin/', 'id' => $data->id]), [
                            'title' => Yii::t('yii', 'Check In'),
                            'data-pjax' => '0',
                        ]);
                    }
                    return 'Checked';
                }
            ];
        }
        $columns['columns'][] =
            [
                'attribute' => 'ticket_number_seq',
                'format' => 'text',
                'label' => 'Ticket Number',
            ];
        echo GridView::widget($columns);

        $columns['dataProvider'] = $model->dpChecked($partyId);

        echo GridView::widget($columns);
        ?>
    </div>
    <?php if($adminType ==='manager'):?>
    <div class="pages-index col-md-10">
        <h3>Ticket Summary</h3>
        <table class="summary">
            <?php $quantity = 0;?>
            <?php $total = 0;?>
            <?php $totalAmount = 0;?>
            <?php foreach($summary as $sum):?>
                <?php $quantity+=$sum->quantity;?>
                <?php $total+=$sum->total;?>
                <?php $totalAmount+=($sum->total*$sum->price);?>
                <tr>
                    <td><?php echo $sum->title?></td>
                    <td>(<?php echo $sum->quantity?></td>
                    <td>Total)</td>
                    <td><?php echo $sum->total?></td>
                    <td>Sold at</td>
                    <td style="text-align: right">$<?= number_format($sum->price, 2, '.', ',')?></td>
                    <td>=</td>
                    <td style="text-align: right"> $<?= number_format(($sum->total*$sum->price), 2, '.', ',')?></td>
                </tr>
            <?php endforeach;?>
            <tr style="border-top: 1px solid #808080">
                <td><b>Total</b></td>
                <td>(<?php echo $quantity?></td>
                <td>Total)</td>
                <td><?php echo $total?></td>
                <td>Sold</td>
                <td></td>
                <td>=</td>
                <td style="text-align: right"> <b>$<?= number_format(($totalAmount), 2, '.', ',')?></b></td>
            </tr>
        </table>
        <?php ?>
    </div>
    <?php endif;?>
</div>
<style>
    table.summary tr td{padding-right: 10px}
</style>