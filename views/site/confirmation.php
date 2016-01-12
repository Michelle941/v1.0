<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\password\PasswordInput;
?>
<section id = "reset-password">
<div class="site-login">
    <?php
    if($type == 'not_valid_hash')
    {
        echo 'Not valid email hash';
    }
    elseif($type == 'reset-password')
    {
        echo "We emailed you password reset instructions along with a dirty picture <br><br>You're welcome!";
    }
    elseif($type == 'success_change_password')
    {
        echo 'Password changed';
    }
    else {
        echo 'Please check your email to complete registration';
    }
?>
</section>

