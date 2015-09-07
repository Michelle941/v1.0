<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\fileinput\FileInput;
use developeruz\tinymce\TinyMce;
?>
<div class="news-index">

    <div class="links-form">
        <?php $form = ActiveForm::begin(
            ['options' => ['enctype'=>'multipart/form-data']]
        ); ?>

        <div class="box box-primary">
            <div class="box-header">
                <h1>Settings</h1>
            </div>

            <div class="box-body">

                <div class="row">
                    <?php
                    foreach($settings as $key => $description)
                    {
                        ?>
                        <div class="col-md-12">
                        <?=$description;?>
                        <input type="text" name="<?=$key;?>" value="<?=\app\models\UserSettings::getValue(Yii::$app->user->getId(), $key);?>">
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
