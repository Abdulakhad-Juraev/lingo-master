<?php


use yii\web\JsonParser;
use yii\web\MultipartFormDataParser;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php'
//    require __DIR__ . '/params-local.php'
);

$config = [
    'id' => 'app-api',
    'name' => "API",
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'homeUrl' => '/api',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'baseUrl' => '/api',
            'parsers' => [
                'application/json' => JsonParser::class,
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'baseUrl' => '/api',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/news-manager/post/one/<slug>' => '/news-manager/post/one',
            ]
        ],
        'session' => [
            'class' => '\yii\web\Session',
            'name' => 'advanced-api',
        ],
        'user' => [
            'class' => '\yii\web\User',
            'identityClass' => 'api\models\User',
            'enableSession' => false,
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-basmala-api', 'httpOnly' => true],
        ],
    ],
    'modules' => [
        'auth' => [
            'class' => 'api\modules\auth\Module',
        ],
        'profile-manager' => [
            'class' => 'api\modules\profile\Module',
        ],
        'test-manager' => [
            'class' => 'api\modules\testmanager\Module',
        ],
        'toefl-manager' => [
            'class' => 'api\modules\toefl\Module',
        ],
        'ielts-manager' => [
            'class' => 'api\modules\ieltsExam\Module',
        ],
    ],
    'as setAppLang' => 'api\behaviors\ChangeLanguageBehavior',
    'params' => $params,
];

return $config;

