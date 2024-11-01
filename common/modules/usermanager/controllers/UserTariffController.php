<?php

namespace common\modules\usermanager\controllers;

use common\modules\usermanager\models\UserPayment;
use common\modules\usermanager\models\UserTariff;
use frontend\web\controllers\BaseController;
use soft\helpers\Html;
use Yii;
use common\modules\usermanager\models\search\UserTariffSearch;
use soft\web\SoftController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class UserTariffController extends BaseController
{



    /**
    * @return mixed
    */
    public function actionIndex()
    {
        $searchModel = new UserTariffSearch();
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
    * @param integer $id
    * @return string
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->ajaxCrud($model)->viewAction();
    }

    /**
    * @return string
    */
    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new UserTariff();
        if ($model->load(Yii::$app->request->post()) && $model->userPayment()){
            return [
                'forceReload' => '#crud-datatable-pjax',
                'forceClose' => true,
            ];
        }
        return [
            'title' => "Yangi qo'shish",
            'content' => $this->renderAjax('create', [
                'model' => $model,
            ]),
            'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit"])

        ];
    }

    /**
    * @param integer $id
    * @return string
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!$model->getIsUpdatable()) {
            forbidden();
        }
        return $this->ajaxCrud($model)->updateAction();
    }

    /**
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $lastUserTariff = $model->user->lastUserTariff;
        if ($model->id < $lastUserTariff->id) {
            forbidden("Ushbu obundan keyin yana obuna sotib olingan");
        }
        if (!$model->getIsDeletable()) {
            forbidden();
        }
        $payment = UserPayment::findOne(['table_id' => $model->id]);
        if ($payment) {
            $payment->delete();
        }
        $model->delete();
        return $this->ajaxCrud($model)->deleteAction();
    }

    /**
    * @param $id
    * @return UserTariff
    * @throws yii\web\NotFoundHttpException
    */
    public function findModel($id)
    {
        $model = UserTariff::find()->andWhere(['id' => $id])->one();
        if ($model == null){
            not_found();
        }
        return $model;
    }
}
