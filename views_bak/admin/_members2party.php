<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row">
    <?php
    foreach($members as $m)
    {
        ?>
        <div class="col-md-2">
            <div class="box box-primary">
                <div class="box-header">
                    <?= Html::button(
                        'X',
                        ['class' => 'btn btn-default btn-sm pull-right',
                         'data-widget' => "remove",
                         'onclick'=> "
                              $.get('".Url::to(['delete-attach', 'id' => $m->id])."', '');
                              return false;",
                        ])
                    ?>
                </div>
                <div class="box-body">
                 <h4><?=$m->user->name.' '.$m->user->last_name;?></h4>
                <img src="/upload/50x50<?=$m->user->getImage();?>">
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
