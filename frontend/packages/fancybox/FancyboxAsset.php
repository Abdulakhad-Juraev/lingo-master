<?php

namespace frontend\packages\fancybox;

use yii\web\AssetBundle;

class FancyboxAsset extends AssetBundle
{

    public $sourcePath = '@frontend/packages/fancybox/assets';

    public $css = [
        'fancybox.css',
    ];

    public $js = [
        'fancybox.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}

