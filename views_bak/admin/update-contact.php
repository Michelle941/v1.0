<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="pages-update">
    <?php $form = ActiveForm::begin([
            'id' => 'contact-form',
        ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'organization')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
$js = <<<JS
// get the form id and set the event
$('#contact-form :submit').on('click', function(e){
    e.preventDefault();
    submitForm($(this.form), 'contact');
});
JS;
$this->registerJs($js);