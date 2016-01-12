<?php

if (file_exists(__DIR__ . '/db.local.php')) {
    return require __DIR__ . '/db.local.php';
}

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=941_testing',
    'username' => 'root',
    'password' => 'zsexdrcft',
    'charset' => 'utf8',
];
