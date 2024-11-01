<?php

namespace frontend\controllers;


use frontend\models\LoginForm;

use frontend\models\ResetForm;
use frontend\models\SignupForm;
use soft\web\SoftController;
use Yii;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\web\Response;


/**
 * Site controller
 */
class SiteController extends SoftController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'leave-email' => ['post'],
                    'text-error' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],

        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->redirect('/admin');
    }

}
