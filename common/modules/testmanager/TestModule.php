<?php

namespace common\modules\testmanager;

use frontend\assets\MathXmlViewer;

/**
 * testmanager module definition class
 */
class TestModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\testmanager\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

//        MathXmlViewer::register(\Yii::$app->view);

        // custom initialization code goes here
    }
}
