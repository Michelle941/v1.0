<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\fileinput\FileInput;
use developeruz\tinymce\TinyMce;

$this->title = 'Config';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <div class="links-form">
        <?php $form = ActiveForm::begin(
            ['options' => ['enctype'=>'multipart/form-data']]
        ); ?>

        <div class="box box-primary">
            <div class="box-header">
                <h1>Main page photo</h1>
            </div>

            <div class="box-body">

                <div class="row">
                    <?php
                    for($i=1; $i<5; $i++) {
                        ?>
                        <div class="col-md-6">
                            <div class="box box-solid">
                                <div class="box-header with-border"><h3>Image <?=$i;?></h3></div>
                                <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php
                                        echo 'Text: ' . Html::textInput('text'.$i, $params['mainPage']['text'.$i]);
                                        echo '<br>';
                                        echo FileInput::widget([
                                            'name' => 'image'.$i,
                                            'thumbnail' => '<img src="' . Yii::$app->params['flayerPath'] . '/' . $params['mainPage']['image'.$i] . '">',
                                            'style' => FileInput::STYLE_IMAGE
                                        ]);
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        echo 'URL: ' . Html::textInput('url'.$i, $params['mainPage']['url'.$i]);
                                        echo '  &nbsp;&nbsp;'.Html::checkbox('is_popup'.$i, $params['mainPage']['is_popup'.$i]).' open in popup';
                                        echo '<br>';
                                        ?>
                                        Hover:<br>
                                        <?php
                                        echo FileInput::widget([
                                            'name' => 'image'.$i.'hover',
                                            'thumbnail' => '<img src="' . Yii::$app->params['flayerPath'] . '/' . $params['mainPage']['image'.$i.'hover'] . '">',
                                            'style' => FileInput::STYLE_IMAGE
                                        ]);
                                        ?>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <?= Html::hiddenInput('is_send', 1); ?>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header">
                <h1>Email text</h1>
            </div>

            <div class="box-body">
                <h3>Welcome message text</h3>
                <?= TinyMce::widget( [
                    'name' => 'welcome_letter',
                    'value' =>  $params['mainPage']['welcome_letter'],
                    'options' => ['rows' => 6]
                ]);
                ?>

                <h3>Registration email</h3>
                <?= Html::textInput('registration_email_subject', $params['mainPage']['registration_email_subject']);?>
                <?= TinyMce::widget( [
                    'name' => 'registration_email',
                    'value' =>  $params['mainPage']['registration_email'],
                    'options' => ['rows' => 6]
                ]);
                ?>

                <h3>Reset password email</h3>
                <?= Html::textInput('reset_password_subject', $params['mainPage']['reset_password_subject']);?>
                <?= TinyMce::widget( [
                    'name' => 'reset_password_email',
                    'value' =>  $params['mainPage']['reset_password_email'],
                    'options' => ['rows' => 6]
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>
