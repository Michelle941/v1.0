<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<div class="user-search">

    <?php $form = ActiveForm::begin([
            'method' => 'get',
            'id' => 'user-form',
            'action' => Url::to(['/admin/attach-user/', 'partyID' => $partyID])
        ]); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'last_name') ?>
            <?= $form->field($model, 'dob') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'zip_code') ?>
            <?= $form->field($model, 'city') ?>
            <?= $form->field($model, 'region') ?>
            <?= $form->field($model, 'state') ?>
        </div>
    </div>
    <div class="row" style="display: none" id="searchFormDiv">
        <div class="col-md-6">
            <?= $form->field($model, 'gender') ?>
            <?= $form->field($model, 'rank') ?>
            <?= $form->field($model, 'relation_status') ?>
            <?= $form->field($model, 'tag_line') ?>

            <?= $form->field($model, 'work') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'premium_status') ?>
            <?= $form->field($model, 'premium_type') ?>
            <?= $form->field($model, 'premium_start_date') ?>
            <?= $form->field($model, 'premium_end_date') ?>

            <?= $form->field($model, 'love') ?>
        </div>
    </div>
    <a href="#" onclick="$('#searchFormDiv').toggle(); return false;">more</a>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="row">
    <?php
    foreach($members as $m)
    {
        ?>
        <div class="col-md-2">
            <h4><?=$m->name.' '.$m->last_name;?></h4>
            <img src="/upload/50x50<?=$m->getImage();?>"><br>
            <a href="<?=Url::to(['attach', 'id' => $m->id, 'partyID' => $partyID]);?>" class="attach">Attach</a>
        </div>
    <?php
    }
    ?>
    </div>
</div>
<?php
$js = <<<JS
// get the form id and set the event
$('#user-form :submit').on('click', function(e){
    e.preventDefault();
    submitFormMoreTime($(this.form));
});
$('.attach').click(function(e)
{
    e.preventDefault();
    $.get(this.href, function(data)
    {
         $("#attached").html(data);
         $('#modal').modal('hide');
    });
}
);
JS;
$this->registerJs($js);