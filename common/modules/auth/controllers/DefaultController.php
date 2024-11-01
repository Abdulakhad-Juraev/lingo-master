<?php
namespace common\modules\auth\controllers;
use frontend\web\controllers\BaseController;


/**
 * Default controller for the `auth` module
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
