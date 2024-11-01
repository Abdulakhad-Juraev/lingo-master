<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'dumper'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        'migrate-all' => [
            'class' => 'soft\db\MigrateController',
            'migrationNamespaces' => [
                'common\modules\tempUser\migrations',
                'common\modules\testmanager\migrations',
                'common\modules\usermanager\migrations',
                'common\modules\toeflExam\migrations',
                'common\modules\ieltsExam\migrations',
                'common\modules\tariff\migrations',
            ],
        ]
    ],
    'components' => [

        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'dumper' => [
            'class' => \gofuroov\dumper\mysql\Dumper::class,
            'name' => 'db',
            'append_name' => date('_H_i_s_Y_m_d'),
            'path' => '@runtime',
            'send_via_telegram' => true,
            'bot_token' => '2082349538:AAFsVb5qwIIDFeV0WztTroDXJBd6JTabVDA',
            'chat_id' => '-1001649834535',
            'delete_after_send' => true,
        ],

    ],
    'params' => $params,
];
