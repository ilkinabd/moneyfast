<?php

use app\components\DeamonService;
use app\components\DeamonServiceInterface;
use app\components\DigitalSignService;
use app\components\DigitalSignServiceInterface;
use yii2tech\filestorage\local\Storage;
use yii\httpclient\Client;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
        '@keys' => '@app/keys'
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
        'db' => $db,
    ],
    'params' => $params,
    'container' => [
        'definitions' => [
            Storage::class => [
                'class' => Storage::class,
                'basePath' => '@app/files',
                'baseUrl' => '@app/files',
                'dirPermission' => 0775,
                'filePermission' => 0755,
                'buckets' => [
                    'dataFiles' => [
                        'baseSubPath' => 'data',
                        // 'fileSubDirTemplate' => '{^name}/{^^name}',
                    ],
                    // 'imageFiles' => [
                    //     'baseSubPath' => 'image',
                    //     'fileSubDirTemplate' => '{ext}/{^name}/{^^name}',
                    // ],
                ]
            ],
            DeamonServiceInterface::class => [
                'class' => DeamonService::class
            ],
            Client::class => [
                'class' => Client::class
            ],
            DigitalSignServiceInterface::class => [
                'class' => DigitalSignService::class,
                'privateKey' => '@keys/private_key.txt',
                'publicKey' => '@keys/public_key.txt'
            ]
        ]
    ]
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
