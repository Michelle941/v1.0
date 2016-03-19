<?php
use dosamigos\fileupload\FileUploadUI;
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="">
            <a href="<?=Url::to(['/admin/update-party', 'id' => $id]);?>">Main info</a>
        </li>
        <li class="">
            <a href="<?=Url::to(['/admin/update-party', 'id' => $id, 'tab' => 2]);?>">Flash Sale</a>
        </li>
        <li class="">
            <a href="<?=Url::to(['/admin/update-party', 'id' => $id, 'tab' => 3]);?>">Regular Sale</a>
        </li>
        <li class="">
            <a href="<?=Url::to(['/admin/update-party', 'id' => $id, 'tab' => 4]);?>">Past Party</a>
        </li>
        <li class="active">
            <a data-toggle="tab" href="#tab_4" aria-expanded="true">Photo</a>
        </li>
        <li class="">
            <a href="<?=Url::to(['/admin/update-party', 'id' => $id, 'tab' => 5]);?>">Attach members profile</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab-4">
            <br><br>

<?= FileUploadUI::widget([
        'name' => 'photo',
        'url' => Url::to(['/admin/upload', 'partyID' => $id]),
        'gallery' => false,
        'fieldOptions' => [
            'accept' => 'image/*'
        ],
        'clientOptions' => [
            'maxFileSize' => 2000000
        ],
        'clientEvents' => [
            'fileuploaddone' => 'function(e, data) {
                                    console.log(e);
                                    console.log(data);
                                }',
            'fileuploadfail' => 'function(e, data) {
                                    console.log(e);
                                    console.log(data);
                                }',
        ],
    ]);
?>
<div class="row">
<?php
foreach($photos as $photo)
{
    ?>
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header">
                <?php if($photo->status == 0){ ;?>
                <?= Html::a('Approve', Url::to(['approve', 'id' => $photo->id]),
                        ['class' => 'btn btn-default btn-sm fa fa-edit modalButton']
                    );
                ?>

                <?php
                echo \yii\helpers\Html::button('X', [
                        'class' => 'btn btn-default btn-sm pull-right',
                        'title' => 'Delete',
                        'data-widget' => "remove",
                        'onclick'=> "
                                $.get('".Url::to(['delete-photo', 'id' => $photo->id])."', '');
                                return false;",
                    ]);
                }
                ?>
            </div>
            <div class="box-body">
                <img src="<?=Yii::$app->params['imagePath'];?><?=$photo->image;?>" width="250" height="250">
            </div>
            <div class="box-footer">
                upload at <?=date('d.m.Y H:i', $photo->created_at);?> by <?=$photo->user->name.' '.$photo->user->last_name;?>
            </div>
        </div>
    </div>
    <?php
}
?>
</div>



        </div>
    </div>
</div>
