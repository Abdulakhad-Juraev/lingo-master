<?php

namespace common\modules\ieltsExam\controllers;

use frontend\web\controllers\BaseController;
use Yii;
use common\modules\ieltsExam\models\IeltsResult;
use common\modules\ieltsExam\models\search\IeltsResultSearch;
use yii\web\NotFoundHttpException;

class IeltsResultController extends BaseController
{

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $query = IeltsResult::find()
            ->andWhere(['is not', 'speaking_score', null])
            ->andWhere(['is not', 'writing_score', null]);
        $searchModel = new IeltsResultSearch();
        $dataProvider = $searchModel->search($query);
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
        $model = new IeltsResult();
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
     * @return IeltsResult
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = IeltsResult::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }
}
