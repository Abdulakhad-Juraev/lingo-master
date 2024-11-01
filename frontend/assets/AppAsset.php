<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $baseUrl = '/template';

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
