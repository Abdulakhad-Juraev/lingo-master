<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AdminLteAsset extends AssetBundle
{
    public $css = [

        'css/icons.min.css',
        'css/app.min.css',
    ];

    public $baseUrl = '@web/adminlte/';

    public $js = [
        'libs/metismenu/metisMenu.min.js',
        'libs/simplebar/simplebar.min.js',
        'libs/node-waves/waves.min.js',
        'libs/apexcharts/apexcharts.min.js',
        'js/pages/dashboard.init.js',
        'js/app.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\YiiAsset',
    ];
}