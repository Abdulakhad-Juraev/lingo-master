<?php

namespace common\modules\usermanager\controllers;

use common\models\ImportExcel;
use common\models\search\BalanceSearch;
use common\modules\testmanager\models\search\TestResultSearch;
use common\modules\testmanager\models\TestResult;
use common\modules\usermanager\models\Balance;
use common\modules\usermanager\models\search\UserPaymentSearch;
use common\modules\usermanager\models\search\UserSearch;
use common\modules\usermanager\models\search\UserDeviceSearch;
use common\modules\usermanager\models\User;
use common\modules\usermanager\models\UserDevice;
use common\modules\usermanager\models\UserPayment;
use frontend\web\controllers\BaseController;
use Yii;
use yii\base\Exception;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class UserController extends BaseController
{
    public function actionIndex(): string
    {
        $searchModel = new UserSearch();
        $query = User::find()
            ->andWhere(['not', ['type_id' => null]])
            ->andWhere(['type_id' => User::TYPE_ID_USER]);
        $dataProvider = $searchModel->search($query);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = User::findOne(['id' => $id]);
        return $this->render('view', [
            'model' => $model,
        ]);
    }


    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionChange($id)
    {
        $model = $this->findModel($id);

        if ($model->status == User::STATUS_ACTIVE) {
            $model->status = User::STATUS_INACTIVE;
        } else {
            $model->status = User::STATUS_ACTIVE;
        }
        $model->save(false);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = User::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }


    /**
     * @param $id
     * @return string
     */
    public function actionUserDevice($id)
    {
        $model = User::findOne($id);
        $searchModel = new UserDeviceSearch();
        $query = UserDevice::find()->andWhere(['user_id' => $id]);
        $dataProvider = $searchModel->search($query);
        return $this->render('user-device', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUserPayment($id)
    {
        $model = User::findOne($id);
        $searchModel = new UserPaymentSearch();
        $query = UserPayment::find()->andWhere(['user_id' => $id]);
        $dataProvider = $searchModel->search($query);
        return $this->render('user-payment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    public function actionTestResult($id): string
    {
        $model = User::findOne($id);
        $searchModel = new TestResultSearch();

        $query = TestResult::find()
            ->andWhere(['user_id' => $id]);

        $dataProvider = $searchModel->search($query);

        return $this->render('user-test-result', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }


}