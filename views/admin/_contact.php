<?php
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\Html;

if(count($contact))
{
    foreach ($contact as $c) {
        ?>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header">
                    <?= Html::button(
                        '',
                        ['value' => Url::to(['update-contact', 'id' => $c->id]),
                            'class' => 'btn btn-default btn-sm fa fa-edit modalButton'
                        ])
                    ?>

                    <?php
                    echo \yii\helpers\Html::button('X', [
                           'class' => 'btn btn-default btn-sm pull-right',
                            'title' => 'Delete',
                            'data-widget' => "remove",
                            'onclick'=> "
                                $.get('".Url::to(['delete-contact', 'id' => $c->id, 'partyID' => $id])."', '');
                                return false;",
                        ]);
                    ?>
                </div>
                <div class="box-body">
                    <?php
                    echo DetailView::widget([
                            'model' => $c,
                            'attributes' => [
                                'name',
                                'organization',
                                'email',
                                'phone',
                            ]]);
                    ?>
                </div>
            </div>
        </div>
    <?php
    }

}