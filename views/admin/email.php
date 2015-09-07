<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
?>
<div class="email-form">
    <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#tab_1" aria-expanded="false">Send Email</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#tab_2" aria-expanded="true">Members groups</a>
        </li>
        <li class="">
            <a data-toggle="tab" href="#tab_3" aria-expanded="true">Inbox</a>
        </li>
    </ul>
    <div class="tab-content">
    <div id="tab_1" class="tab-pane active">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-lg-12">
                Members: <?= Html::dropDownList('forGroup', null, \app\models\UserGroup::getAsArray());?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                <?= Html::textarea('text', null, [
                    'rows' => 10,
                    'cols' => 109
                ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-lg-12">
                     <?= Html::submitButton('Send email') ?>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
    </div>
    <div id="tab_2" class="tab-pane">
        <?= Html::button(
            'Add new group',
            ['value' => Url::to(['add-group']),
                'class' => 'btn btn-success modalButton'
            ]) ?>

        <?= GridView::widget([
            'dataProvider' => $groupList,
            'columns' => [
                'title',
                [
                    'class'     => DataColumn::className(),
                    'attribute' => 'kol',
                    'format'    => 'html',
                    'value'     => function($data) { return count($data->users); }
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;{delete}',
                    'buttons' =>
                        [
                            'update' => function ($url, $model) {
                                    return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
                                        [
                                            'title' => Yii::t('yii', 'Add member'),
                                            'data-pjax' => '0',
                                            'class' => 'modalButton',
                                            'value' => Url::toRoute(['/admin/find-user', 'id' => $model->id])
                                        ]); },
                            'view' => function ($url, $model) {
                                    return Html::button('<span class="glyphicon glyphicon-eye-open"></span>',
                                        [
                                            'title' => Yii::t('yii', 'View members in group'),
                                            'data-pjax' => '0',
                                            'class' => 'modalButton',
                                            'value' => Url::toRoute(['/admin/user-in-group', 'id' => $model->id])
                                        ]); },
                            'delete' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['admin/delete-group','id' => $model->id]), [
                                            'title' => Yii::t('yii', 'Delete'),
                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'data-method' => 'post',
                                            'data-pjax' => '1',
                                        ]);
                                }
                        ]
                ],
            ],
        ]); ?>
    </div>
        <div id="tab_3" class="tab-pane">
               <div class="box-group" id="accordion">
                   <?php
                   foreach($inbox as $message)
                   {
                   ?>
                   <div class="panel box">
                       <div class="box-header">
                           <h4 class="box-title">
                               <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$message->id;?>">
                                  From <?=$message->sender->name.' '.$message->sender->last_name;?>
                               </a>
                           </h4>
                       </div>
                       <div style="" id="collapse<?=$message->id;?>" class="panel-collapse collapse" aria-expanded="false">
                           <div class="box-body">
                               <?=$message->text;?>
                               <?php $form = ActiveForm::begin(); ?>
                               <?= Html::textarea('answer', null, [
                                   'rows' => 3,
                                   'cols' => 100
                               ]) ?>
                               <?=Html::hiddenInput('re_id', $message->id);?>
                               <?=Html::hiddenInput('user_from', $message->user_from);?>
                               <br>
                               <?= Html::submitButton('Send answer') ?>
                               <?php ActiveForm::end(); ?>
                           </div>
                       </div>
                   </div>
                <?php } ?>
               </div>
        </div>
    </div>
    </div>
</div>
<?php
Modal::begin([
    'id' => 'modal'
]);

echo "<div id='modalContent'></div>";

Modal::end();
?>