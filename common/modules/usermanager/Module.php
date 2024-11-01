<?php

namespace common\modules\usermanager;

/**
 * usermanager module definition class
 */
class Module extends \yii\base\Module
{

    public $defaultRoute = 'user';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\usermanager\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
