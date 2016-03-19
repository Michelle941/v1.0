<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row">
    <?php
    foreach($users as $user2group)
    {
        $m = $user2group->users;
        ?>
        <div class="col-md-2">
            <div class="box box-primary">
                <div class="box-header">
                <?= Html::button(
                'X',
                ['class' => 'btn btn-default btn-sm pull-right',
                    'data-widget' => "remove",
                    'onclick'=> "
                              $(this).closest('.box').hide();
                              $.get('".Url::to(['delete-from-group', 'id' => $user2group->id])."', '');
                              return true;",
                ])
            ?>
                </div>
                <div class="box-body">
                <strong><?=$m->name.' '.$m->last_name;?></strong>
                <img src="/upload/50x50<?=$m->getImage();?>">
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>