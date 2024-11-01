<?php

namespace common\modules\university\controllers;

use frontend\web\controllers\BaseController;
use Yii;
use common\modules\university\models\Faculty;
use common\modules\university\models\search\FacultySearch;
use soft\web\SoftController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class FacultyController extends BaseController
{


    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FacultySearch();
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
        $model = new Faculty(['status' => Faculty::STATUS_ACTIVE]);
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
     * @return Faculty
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = Faculty::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }

    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionChange($id)
    {
        $model = $this->findModel($id);

        if ($model->status == Faculty::STATUS_ACTIVE) {
            $model->status = Faculty::STATUS_INACTIVE;
        } else {
            $model->status = Faculty::STATUS_ACTIVE;
        }
        $model->save(false);
        return $this->redirect(Yii::$app->request->referrer);
    }
}
