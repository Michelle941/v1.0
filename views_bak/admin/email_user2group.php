<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<h1>Users in group "<?=$group->title;?>"</h1>
<div class="user-search">

    <?php $form = ActiveForm::begin([
            'method' => 'post',
            'id' => 'add-user-form',
            'action' => Url::to(['/admin/add-user-to-group/'])
        ]); ?>
    <?=Html::hiddenInput('groupID', $group->id);?>
    <div class="row">
        <?php
        foreach($members as $m)
        {
            ?>
            <div class="col-md-2">
                <input type="checkbox" name="User[]" value="<?=$m->id;?>">
                <strong><?=$m->name.' '.$m->last_name;?></strong>
                <img src="/upload/50x50<?=$m->getImage();?>"><br>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= Html::submitButton('Add user in group', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<script>
    $('#user-form :submit').on('click', function(e){
        e.preventDefault();
        submitFormMoreTimePost($(this.form));
    });

    $('#add-user-form :submit').on('click', function(e){
        e.preventDefault();
        submitFormMoreTimePost($(this.form));
    });
</script>