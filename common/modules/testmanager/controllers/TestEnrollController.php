<?php

namespace common\modules\testmanager\controllers;

use common\modules\testmanager\models\UserPayment;
use frontend\web\controllers\BaseController;
use soft\helpers\Html;
use Yii;
use common\modules\testmanager\models\TestEnroll;
use common\modules\testmanager\models\search\TestEnrollSearch;
use soft\web\SoftController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class TestEnrollController extends BaseController
{


    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestEnrollSearch();
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


    public function actionCreate()
    {
        $model = new TestEnroll();

        Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;
        if ($model->load($request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            $success = true;
            try {
                $success &= $model->save();
                $user_payment = new UserPayment([
                    'user_id' => $model->user_id,
                    'amount' => $model->price,
                    'type_id' => $model->payment_type_id,
                    'table_id'=>$model->id,
                    'owner_id'=>UserPayment::OWNER_ID_TESTENROLL
                ]);
                $success &= $user_payment->save();
                if ($success) {
                    $transaction->commit();
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'forceClose' => true,
                    ];
                } else {
                    $transaction->rollBack();
                    not_found($model->getFirstErrorMessage());
                }

            } catch (\Exception $exception) {
                $transaction->rollBack();
                not_found($exception->getMessage());
            }

        } else {
            return [
                'title' => "Yangi qo'shish",
                'content' => $this->renderAjax('create', [
                    'model' => $model,
                ]),
                'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                    Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit"])

            ];
        }

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
     * @return TestEnroll
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = TestEnroll::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }
}
