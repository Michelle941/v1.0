<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="user-group-form">

    <?php $form = ActiveForm::begin([
            'id' => 'email-group'
        ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton('Next') ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
$('#email-group :submit').on('click', function(e){
    e.preventDefault();
    submitFormMoreTimePost($(this.form));
});
</script>