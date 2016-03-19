<div class="row">
<?php
foreach($staff as $s)
{
    //TODO: add ajax
    ?>
    <div class="col-lg-3">
        <img src="/upload/50x50<?=$s->user->avatar;?>"><br>
        <?=$s->user->name.' '.$s->user->last_name;?><br>
        <a href="<?=\yii\helpers\Url::to(['/admin/attach-staff', 'partyID' => $partyID, 'userID' => $s->user->id]);?>" class="attach-staff">attach</a>
    </div>
    <?php
}
?>
</div>
<?php
$js = <<<JS
$('.attach-staff').click(function(e)
{
    e.preventDefault();
    $.get(this.href, function(data)
    {
        $("#attach-staff").html(data);
        $('#modal').modal('hide');
    });
}
);
JS;
$this->registerJs($js);?>