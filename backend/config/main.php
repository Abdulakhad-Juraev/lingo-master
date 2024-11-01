<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);


return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => 'uz',
    'homeUrl' => ['/site/index'],
    'modules' => [
        'university-manager' => [
            'class' => 'common\modules\university\Module',
        ],
        'translation-manager' => [
            'class' => 'common\modules\translation\TranslationManager',
        ],
        'auth-manager' => [
            'class' => 'common\modules\auth\Module',
        ],
        'usermanager' => [
            'class' => 'common\modules\usermanager\Module',
        ],
        'test-manager' => [
            'class' => 'common\modules\testmanager\TestModule',
        ],
        'region-manager' => [
            'class' => 'common\modules\regionmanager\RegionModule',
        ],
        'profile-manager' => [
            'class' => 'backend\modules\profilemanager\Module',
        ],
        'toefl-exam' => [
            'class' => 'common\modules\toeflExam\Module',
        ],
        'ielts-exam' => [
            'class' => 'common\modules\ieltsExam\Module',
        ],
        'tariff-manager' => [
            'class' => 'common\modules\tariff\Module',
        ],
    ],
    'as setAppLang' => 'soft\i18n\ChangeLanguageBehavior',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-sugar', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'soft\web\UrlManager',
            'isMultilingual' => true,
            'baseUrl' => '/admin',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],

        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '@web/template/adminlte3/base-assets',
                    'js' => ['js/jquery.min.js']
                ],

                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '@web/template/adminlte3/base-assets',
                    'css' => [
                        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback',
                        'fontawesome-free/css/all.min.css',
                        'css/adminlte.min.css',
                    ]
                ],

                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => '@web/template/adminlte3/base-assets',
                    'js' => ['js/bootstrap.bundle.min.js',]
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'js' => [],
                ],
                'yii\bootstrap4\BootstrapAsset' => [
                    'sourcePath' => null,
                    'css' => [],
                ],
            ]
        ],

    ],

    'params' => $params,
];
