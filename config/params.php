<?php
//Yii::$app->params

$siteUrl = 'http://'.$_SERVER['SERVER_NAME'];;
return [
    'previewSize' => [[30, 30], [95, 95], [160, 160],[255, 255],[350, 350], [540, 540]],
    'previewSizeSquare' => [[30, 30],[95, 95], [160, 160],[255, 255],[350, 350], [540, 540]],
    'avatarSize' => [[30, 30],[50, 50],[160, 160], [255, 255],[350, 350], [540, 540]],
    'avatarSizeSquare' => [[30, 30],[95, 95],[160, 160], [255, 255],[350, 350], [540, 540]],
    'flayerSize' => [[150, 150]],
    'supportEmail' => 'holla@941socialclub.com',
    'passwordResetTokenExpire' => 60*60*24,   // время time 24 часа на подтверждение email
    'domen' => $siteUrl,
    'imageUploadDir' => '/web/upload/',
    'imagePath' => $siteUrl.'/upload/',
    'flayerUploadDir' => '/web/image/',
    'flayerPath' => $siteUrl.'/image',
    'staffRoles' => "'staff-level1', 'staff-level2', 'staff-level3'",
    'serviceName' => '941 Social Club', // name при отправке сообщений от имени администрации
    'instagramApiKey' =>'2c5211a5d3b1462f89df7ef812c86513',
    'instagramApiSecret' =>'acebb20c9dfc41aabf2c33fb8f627a8d'

];
