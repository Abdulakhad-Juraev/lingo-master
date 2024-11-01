<?php

namespace common\modules\university\controllers;

use frontend\web\controllers\BaseController;
use yii\web\Controller;

/**
 * Default controller for the `university` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
