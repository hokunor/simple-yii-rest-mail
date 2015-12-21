<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'restapi',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
    /*    'mailgearman' => [
            'identityClass' => 'app\models\MailGearman',
            'enableAutoLogin' => true,
        ],*/
        'errorHandler' => [
            'errorAction' => 'mail/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
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
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'mails'],
            ],
        ],
        'gearman' => [
            'class' => 'filsh\yii2\gearman\GearmanComponent',
            'servers' => [
                ['host' => '127.0.0.1', 'port' => 4730],
            ],
            'user' => 'www-data',
            'jobs' => [
                'mailJob' => [
                    'class' => 'common\jobs\MailJob'
                ],
            ]
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'controllerMap' => [
        'gearman' => [
            'class' => 'filsh\yii2\gearman\GearmanController',
            'gearmanComponent' => 'gearman'
        ],
    ],
    'modules'=>array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'pick up a password here',
        ),
    ),
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
/*
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];*/
}

return $config;
