<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'homeUrl' => ['branch/'],
    'language' => 'uz',
    'components' => [
        'request' => [
            'baseUrl' => '/',
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'soft\web\UrlManager',
            'baseUrl' => '/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

                '<lang:\w+>/documents/<category>' => 'document/index',
                '<lang:\w+>/documents' => 'document/index',
                '<lang:\w+>/document/<id>' => 'document/detail',

                '<lang:\w+>/posts' => 'post/index',
                '<lang:\w+>/post/<slug>' => 'post/detail',

                '<lang:\w+>/interactive-services' => 'interactive-service/index',

                '<lang:\w+>/photo-galleries' => 'gallery/photo-galleries',
                '<lang:\w+>/video-gallery' => 'gallery/video-gallery',
                '<lang:\w+>/photo-gallery/<slug>' => 'gallery/photo-gallery',

                '<lang:\w+>/manage' => 'staff/manage',
                '<lang:\w+>/central-apparat' => 'staff/central',

                '<lang:\w+>/schools' => 'school/index',
                '<lang:\w+>/school/<slug>' => 'school/detail',

                '<lang:\w+>/page/<slug>' => 'site/page',
                '<lang:\w+>/' => 'site/index',
            ],
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '/template',
                    'js' => ['https://code.jquery.com/jquery-3.6.0.min.js']
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '/template',
                    'css' => [
//                        'libs/fontawesome-free-5.15.4-web/css/all.min.css',
//                        'libs/bootstrap-4.3.1-dist/css/bootstrap.min.css',
                    ]
                ],

                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '/template',
                    'js' => [
                        'js/bootstrap.min.js'
                    ]
                ],
                'yii\bootstrap4\BootstrapAsset' => [
                    'sourcePath' => null,
                    'css' => [],
                    'depends' => [
                        'yii\bootstrap\BootstrapAsset'
                    ],
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'js' => [],
                    'depends' => [
                        'yii\bootstrap\BootstrapPluginAsset'
                    ]
                ],

            ]
        ],
    ],
    'on beforeAction' => function ($event) {
        \soft\helpers\SiteHelper::setLanguage();
    },
    'params' => $params,
];
