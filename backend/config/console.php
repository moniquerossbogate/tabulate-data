<?php

use yii\queue\LogBehavior;
use yii\rbac\DbManager;

$params = array_merge(
    require __DIR__ . '/params.php',
    file_exists(__DIR__ . '/params-local.php') ? require __DIR__ . '/params-local.php' : []
);

$db = array_merge(
    require __DIR__ . '/db.php',
    file_exists(__DIR__ . '/db-local.php') ? require __DIR__ . '/db-local.php' : []
);

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['queue', 'log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@tests' => '@app/tests',
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
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'ttr' => 3 * 60, // Max time for job execution
            'attempts' => 5, // Max number of attempts
            'as log' => LogBehavior::class,
            'db' => 'db',
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class,
        ],
        'authManager' => [
            'class' => DbManager::class, // yii\rbac\PhpManager or 'yii\rbac\DbManager'
        ]
    ],
    'params' => $params,
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
