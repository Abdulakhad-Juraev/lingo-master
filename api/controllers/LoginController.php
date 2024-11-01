<?php

namespace api\controllers;

use api\models\LoginForm;
use api\models\User;
use common\models\UserRefreshTokens;
use Yii;
use yii\rest\Controller;

class LoginController extends ApiBaseController
{
    public $authRequired = true;
    /**
     * @var string[]
     */
    public $authOptional = ['index'];

    /**
     * @var string[]
     */
    public $authOnly = ['index'];


    public function actionIndex()
    {
        return Yii::$app->user->identity->id;
    }
}