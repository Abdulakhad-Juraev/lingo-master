<?php

/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 26.06.2021, 8:35
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class MathXmlViewer extends AssetBundle
{

    public $sourcePath = '@frontend/web/math';

    public $js = [
        'tex-mml-chtml.js'
    ];

}