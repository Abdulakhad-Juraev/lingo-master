<?php

namespace backend\controllers;

use common\modules\toeflExam\models\EnglishExam;
use common\modules\toeflExam\models\search\EnglishExamSearch;
use frontend\web\controllers\BaseController;
use soft\web\SoftController;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class EnglishExamController extends BaseController
{



    /**
    * @return mixed
    */
    public function actionIndex()
    {
        $searchModel = new EnglishExamSearch();
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
        $model = new EnglishExam();
        return $this->ajaxCrud($model)->createAction();
    }

    /**
    * @param string $id
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
    * @param string $id
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
    * @return EnglishExam
    * @throws yii\web\NotFoundHttpException
    */
    public function findModel($id)
    {
        $model = EnglishExam::find()->andWhere(['id' => $id])->one();
        if ($model == null){
            not_found();
        }
        return $model;
    }
}
