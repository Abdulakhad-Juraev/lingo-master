<?php

namespace common\modules\usermanager\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use frontend\web\controllers\BaseController;
use common\modules\usermanager\models\UserDevice;
use common\modules\usermanager\models\search\UserDeviceSearch;
use yii\web\Response;

class UserDeviceController extends BaseController
{
    /**
    * @return mixed
    */
    public function actionIndex()
    {
        $searchModel = new UserDeviceSearch();
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
        $model = new UserDevice();
        return $this->ajaxCrud($model)->createAction();
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
        if (!$model->getIsDeletable()) {
            forbidden();
        }
        $model->delete();
        return $this->ajaxCrud($model)->deleteAction();
    }



    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionChange($id)
    {
        $model = $this->findModel($id);

        if ($model->status == UserDevice::STATUS_ACTIVE) {
            $model->status = UserDevice::STATUS_INACTIVE;
        } else {
            $model->status = UserDevice::STATUS_ACTIVE;
        }
        $model->save(false);
        return $this->redirect(Yii::$app->request->referrer);
    }
    /**
     * @param $id
     * @return UserDevice
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = UserDevice::find()->andWhere(['id' => $id])->one();
        if ($model == null){
            not_found();
        }
        return $model;
    }

}
