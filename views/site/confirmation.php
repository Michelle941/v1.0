<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\password\PasswordInput;
?>
<div class="site-login">
    <?php
    if($type == 'not_valid_hash')
    {
        echo 'Not valid email hash';
    }
    elseif($type == 'reset-password')
    {
        echo "WE EMAILED YOU PASSWORD RESET INSTRUCTIONS<br> ALONG WITH A DIRTY PICTURE. <br><br>YOU'RE WELCOME!";
    }
    elseif($type == 'success_change_password')
    {
        echo 'Password changed';
    }
    else {
        echo 'Please check your email to complete registration';
    }
?>


