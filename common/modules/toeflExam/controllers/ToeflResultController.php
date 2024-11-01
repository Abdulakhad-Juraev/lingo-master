<?php

namespace common\modules\toeflExam\controllers;

use frontend\web\controllers\BaseController;
use Yii;
use common\modules\toeflExam\models\ToeflResult;
use common\modules\toeflExam\models\search\ToeflResultSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ToeflResultController extends BaseController
{



    /**
    * @return mixed
    */
    public function actionIndex()
    {
        $searchModel = new ToeflResultSearch();
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
    * @param string $id
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
        $model = new ToeflResult();
        return $this->ajaxCrud($model)->createAction();
    }

    /**
    * @param string $id
    * @return string
    * @throws NotFoundHttpException if the model cannot be found
    */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//        if (!$model->getIsUpdatable()) {
//            forbidden();
//        }
//        return $this->ajaxCrud($model)->updateAction();
//    }

    /**
    * @param string $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
//    public function actionDelete($id)
//    {
//        $model = $this->findModel($id);
//        if (!$model->getIsDeletable()) {
//            forbidden();
//        }
//        $model->delete();
//        return $this->ajaxCrud($model)->deleteAction();
//    }

    /**
    * @param $id
    * @return ToeflResult
    * @throws yii\web\NotFoundHttpException
    */
    public function findModel($id)
    {
        $model = ToeflResult::find()->andWhere(['id' => $id])->one();
        if ($model == null){
            not_found();
        }
        return $model;
    }
}
