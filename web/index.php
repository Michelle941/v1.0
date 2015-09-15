<?php

// comment out the following two lines when deployed to production
defined('YII_ENV') or define('YII_ENV', getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV'):'dev');
//defined('YII_DEBUG') or define('YII_DEBUG', YII_ENV !== 'prod');
defined('YII_DEBUG') or define('YII_DEBUG', true);

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
