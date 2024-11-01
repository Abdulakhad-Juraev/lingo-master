<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class QuizAsset extends AssetBundle
{
    public $baseUrl = '/quizTemplate';

    public $css = [
        'css/bootstrap.min.css',
        'https://use.fontawesome.com/releases/v6.1.1/css/all.css',
        'css/style.css',
        'css/responsive.css',
        'css/animation.css',
    ];

    public $js = [
        'js/custom.js',
    ];

    public $depends = [
        'yii\bootstrap4\BootstrapPluginAsset',
    ];

}