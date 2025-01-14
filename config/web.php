<?php

$params = require __DIR__ . '/params.php';

return [
    'id' => 'calculator-yii2',
    'name' => 'Калькулятор',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],





    'components' => [
        'request' => [
            'cookieValidationKey' => 'sF6ugQqWMYrNL4Q',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ],
        ],


        'db' => require __DIR__ . '/db.php',
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],


        'errorHandler' => [
            'errorAction' => 'site/error',
        ],


        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning', 'info'],
                ],
            ],
        ],


        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // ...
            ],
        ],

        //добавлено разграничение на пользователей
        'user' => [
            'identityClass' => 'app\models\User',
        ],

        'authManager' => [
        'class' => 'yii\rbac\DbManager',
        ],

    ],




    'params' => $params,


];