<?php

namespace backend\controllers;

use common\models\search\BalanceSearch;
use common\models\User;
use common\modules\usermanager\models\Balance;
use common\modules\usermanager\models\BalanceForm;
use frontend\web\controllers\BaseController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

/**
 * BalanceController implements the CRUD actions for Balance model.
 */
class BalanceController extends BaseController
{
    /**
     * Lists all Balance models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new BalanceSearch();
        $dataProvider = $searchModel->search();
        $drivers = User::find()->select(["CONCAT('(', `id`, ') ', `firstname`, ' ', `lastname`) as first_name"])->where(['is not', 'type_id', null])
            ->indexBy('id')->column();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'drivers' => $drivers
        ]);
    }

    /**
     * Displays a single Balance model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Balance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws ServerErrorHttpException
     */
    public function actionCreate()
    {
        $model = new BalanceForm();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->pay()) {
            \Yii::$app->session->setFlash('success', "Amaliyot muvofaqiyyatli amalga oshdi");

            return $this->redirect(['view', 'id' => $model->getId()]);
        }


        $users = User::find()
            ->select(["CONCAT('ID: ', id, ' | ', full_name) as first_name"])
            ->where(['is not', 'type_id', null])

            ->indexBy('id')
            ->column();

        return $this->render('create', [
            'model' => $model,
            'users' => $users
        ]);
    }

    /**
     * Finds the Balance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Balance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Balance::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param int $driver_id
     * @return string
     */
    public function actionGetBalance(int $user_id): string
    {
        $driver = User::findOne($user_id);

        if (!$driver) {
            return $this->renderContent("<h3>Haydovchi topilmadi</h3>");
        }

        return $this->renderAjax('_balance', [
            'model' => $driver,
        ]);
    }
}
