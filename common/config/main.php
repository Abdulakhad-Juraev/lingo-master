<?php

use common\targets\TelegramTarget;
use yii\log\FileTarget;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'bootstrap' => ['gii'],
    'language' => 'uz',
    'name' => 'Qo\'qon davlat pedagogika instituti',
    'timeZone' => 'Asia/Tashkent',
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'baseUrl' => 'https://qdpi.soften.uz/uploads',
                    'basePath' => '@frontend/web/uploads',
                    'path' => 'files/global',
                    'name' => 'Uploads'
                ],
            ]
        ]
    ],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error'],
                ],
                [
                    'class' => TelegramTarget::class,
                    'levels' => ['error'],
                    'except' => ['yii\web\HttpException:404', 'yii\web\HttpException:401'],
                ],
            ],

        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'i18n' => [
            'translations' => [
                'site*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@soft/i18n/messages',
                    'fileMap' => [
                        'site' => 'site.php',
                    ],
                ],
                'app' => [
                    'class' => 'yii\i18n\DbMessageSource',
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache'
        ],

        'view' => [
            'class' => 'soft\web\View',
        ],
        'formatter' => [
            'class' => 'soft\i18n\Formatter',
        ],
        'acf' => [
            'class' => 'common\modules\acf\components\Acf',
            'fileBasePath' => '@frontend/web/uploads/acf',
            'fileBaseUrl' => '/uploads/acf',
        ],
//        'jwt' => [
//            'class' => \bizley\jwt\Jwt::class,
//            'signer' => 'HS256', // Sizning qo'llab-quvvatlayotgan algoritmingizni tanlang
//            'signingKey' => 'sdjkfdsdjfkdfjkfdfdjkfdjkfdjkfdkjfdskjdf',
//            'verifyingKey' => [
//                'key' =>'dddddddfsadssssddfkgflfgklgjfkgfngfdgfdjgff,gdjgfndfggffglgdfjgfd',
//                'method'=>Jwt::METHOD_PLAIN
//            ],
//            'validationConstraints' => static function (Jwt $jwt) {
//                $config = $jwt->getConfiguration();
//                return [
//                    new SignedWith($config->signer(), $config->verificationKey()),
//                    new LooseValidAt(
//                        new SystemClock(new DateTimeZone(Yii::$app->timeZone)),
//                        new DateInterval('PT10S')
//                    ),
//                ];
//            },
//        ],
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'softModel' => [
                    'class' => 'soft\gii\generators\model\Generator',
                ],
                'softAjaxCrud' => [
                    'class' => 'soft\gii\generators\crud\Generator',
                ],
            ]
        ],
    ],

];
