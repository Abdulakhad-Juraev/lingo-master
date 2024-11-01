<?php

namespace backend\controllers;

use backend\models\LoginForm;
use common\models\Report;
use frontend\web\controllers\BaseController;
use Yii;
use soft\web\SoftController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends BaseController
{

    const DEBT_CLIENT = 2;
    const CREDIT_CLIENT = 1;





    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action..
     *
     * @return \yii\web\Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'blank';
        $model = new LoginForm();
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->redirect(['site/index']);
            }else {
                Yii::$app->user->logout();
            }
//        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionCacheFlush()
    {
        Yii::$app->cache->flush();
        Yii::$app->session->setFlash('success', 'Cache has been successfully cleared');
        return $this->back();
    }

    /**
     * @return string
     */
    public function actionChart()
    {
        return $this->render('chart_info');
    }

    public function actionReport()
    {
        $model = new Report();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $month = $model->month ?? date('m');
            $year = $model->year ?? date('Y');
            $dates = [
                'month' => $month,
                'year' => $year
            ];
            return $this->render('report', [
                'model' => $model,
                'dates' => $dates
            ]);

        } else {
            $month = $model->month ?? date('m');
            $year = $model->year ?? date('Y');

            $dates = [
                'month' => $month,
                'year' => $year
            ];
        }

        return $this->render('report', [
            'model' => $model,
            'dates' => $dates
        ]);
    }


    /**
     * @param $method
     * @param $data
     * @param $token
     * @return mixed
     */
    public function bot($method, $data = [], $token = '5180280407:AAFod0icZq1cuRfZr_gd0sqcmjqk4rFqlQU')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . $token . '/' . $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        return json_decode($res);

    }
}
