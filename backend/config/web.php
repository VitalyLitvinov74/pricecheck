<?php

use app\modules\Product\ProductModule;
use app\modules\UserSettings\UserSettingsModule;

$params = require __DIR__ . '/params.php';
$components = require __DIR__ . '/components.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '9rAj-eQgNRobwDKn1RBmuOsJB_M0pzYw',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
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

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'pattern' => '/user-settings/<action>',
                    'route' => '/user-settings/default/<action>',
                ],
                [
                    'pattern' => '/product-module/<action>',
                    'route' => '/product-module/default/<action>',
                ],
            ],
        ],

    ],
    'modules' => [
        'product-module' => [
            'class' => ProductModule::class,
            'controllerNamespace' => 'app\modules\Product\presentation\controllers',
        ],
        'user-settings' => [
            'class' => UserSettingsModule::class,
            'controllerNamespace' => 'app\modules\UserSettings\presentation\controllers',
        ]
    ],
    'params' => $params,
];
$config['components'] = array_merge($config['components'], $components);
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
