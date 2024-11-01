<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "login/vendor/bootstrap/css/bootstrap.min.css",
        "login/fonts/font-awesome-4.7.0/css/font-awesome.min.css",
        "login/fonts/iconic/css/material-design-iconic-font.min.css",
//        '/fa5/css/fontawesome.css',
//        '/base-assets/fontawesome-free/css/all.min.css',
//        "login/vendor/animate/animate.css",
//        "login/vendor/css-hamburgers/hamburgers.min.css",
//        "login/vendor/animsition/css/animsition.min.css",
//        "login/vendor/select2/select2.min.css",
//        "login/vendor/daterangepicker/daterangepicker.css",
        "login/css/util.css",
        "login/css/main.css",
    ];
    public $js = [
//	"login/vendor/jquery/jquery-3.2.1.min.js",
//	"login/vendor/animsition/js/animsition.min.js",
//	"login/vendor/bootstrap/js/popper.js",
//	"login/vendor/bootstrap/js/bootstrap.min.js",
//	"login/vendor/select2/select2.min.js",
//	"login/vendor/daterangepicker/moment.min.js",
//	"login/vendor/daterangepicker/daterangepicker.js",
//	"login/vendor/countdowntime/countdowntime.js",
	"login/js/main.js",
    ];
    public $depends = [
//        'backend\assets\AdminLte3Asset',
//        'backend\assets\Fa5Asset',
//        'yii\web\YiiAsset',
    ];
}