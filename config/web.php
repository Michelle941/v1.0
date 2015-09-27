<?php
use developeruz\db_rbac\behaviors\AccessBehavior;

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'yt8ns1tt657RKZlVSQPLZdffdszW-vaqxhjiJcwX',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
            //'class'=>'ErrorHandler',
            //'apiKey' => 'f7a2e4342795e5a4e8ab3794cfad3e3e056c14a9',
            //'endpoint'=>'https://airbrake.io/api/v3/projects/116117/notices',
            //'environment'=>'Testing',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<action:(join|email|members|parties|search)>' => 'site/<action>',
                '<action:(preview|member)>/<id:\w+>' => 'site/<action>',

                '<action:(login|logout)>' => 'admin/<action>',

                '<action:(party|page)>/<id:(\w|-)+>' => 'site/<action>',

                '<action:(profile)>' => 'user/<action>',
                '<action:(profile)>/<id:\d+>' => 'user/<action>',

                '<controller:\w+>/<action:(\w|-)+>/<id:\d+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:(\w|-)+>' => '<module>/<controller>/<action>',
                '<controller:\w+>/<action:(\w|-)+>' => '<controller>/<action>',
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'config' => [
            'class' => 'app\models\Config',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '1531637860421782',
                    'clientSecret' => 'cacdc7afda1afb19cbc57076ab4f3d51',
                    'scope'=>'public_profile,email,user_birthday,user_photos,user_location'
                ],
                'instagram' => [
                    'class' => 'kotchuprik\authclient\Instagram',
                    'consumerKey' => 'instagram_client_id',
                    'consumerSecret' => 'instagram_client_secret',
                ],

                //http://instagram.com/developer/authentication/#
            ]
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,//set this property to false to send mails to real email addresses
            //comment the following array to send mail using php's mail function
            /*'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => '',
                'password' => '',
                'port' => '587',
                'encryption' => 'tls',
            ],
            */
        ],
    ],
    'modules' => [
        'permit' => [
            'class' => 'developeruz\db_rbac\Yii2DbRbac',
            'layout' => '/admin'
        ],
    ],
    'params' => $params,
/*    'as AccessBehavior' => [
        'class' => AccessBehavior::className(),
        'rules' =>
            [
                'admin' =>
                [
                     [
                         'actions' => ['login', 'index'],
                         'allow' => true,
                         'roles' => ['?'],
                     ],
                     [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                     ]
                ],

                'site' =>
                [
                    [
                        'allow' => true,
                    ],
                ],
            ]
    ],
*/
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
