<?php

namespace frontend\web\controllers;

use common\models\ProjectContracts;
use soft\web\SoftController;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use common\modules\auth\components\PermissionHelper as P;

class BaseController extends SoftController
{
    /**
     * @param $action
     * @return bool
     * @throws ForbiddenHttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (Yii::$app->authManager->getPermission(Yii::$app->controller->id . "/" . Yii::$app->controller->action->id)) {
            if (!P::can(Yii::$app->controller->id . "/" . Yii::$app->controller->action->id)) {
                throw new ForbiddenHttpException(Yii::t('app', 'Access denied'));
            }
        }

        return parent::beforeAction($action);
    }

    /**
     * @return array[]
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'update-value' => ['POST'],
                ],
            ],
        ];
    }
}