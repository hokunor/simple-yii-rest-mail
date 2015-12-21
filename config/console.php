<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
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
                    'class' => 'app\common\jobs\MailJob'
                ],
            ]
        ],
        'db' => $db,
    ],
    'controllerMap' => [
        'gearman' => [
            'class' => 'filsh\yii2\gearman\GearmanController',
            'gearmanComponent' => 'gearman'
        ],
    ],
    'params' => $params,
];
