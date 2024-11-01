<?php

namespace common\modules\ieltsExam\controllers;

use common\modules\ieltsExam\models\IeltsQuestionGroup;
use common\modules\ieltsExam\models\search\IeltsQuestionGroupSearch;
use common\modules\toeflExam\models\EnglishExam;
use frontend\web\controllers\BaseController;
use Yii;

class IeltsQuestionGroupReadingController extends BaseController
{
    public function actionIndex($id)
    {
        $exam = EnglishExam::findModel($id);
        $query = IeltsQuestionGroup::find()->andWhere(['type_id' => IeltsQuestionGroup::TYPE_READING]);
        $searchModel = new IeltsQuestionGroupSearch();
        $dataProvider = $searchModel->search($query);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'exam' => $exam
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->ajaxCrud($model)->viewAction();
    }

    public function actionCreate($id)
    {
        $exam = EnglishExam::findModel($id);
        $model = new IeltsQuestionGroup([
            'exam_id' => $exam->id,
            'type_id' => IeltsQuestionGroup::TYPE_READING,
            'status' => IeltsQuestionGroup::STATUS_ACTIVE
        ]);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['index', 'id' => $id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'exam' => $exam
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!$model->getIsUpdatable()) {
            forbidden();
        }
        return $this->ajaxCrud($model)->updateAction();
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if (!$model->getIsDeletable()) {
            forbidden();
        }
        $model->delete();
        return $this->ajaxCrud($model)->deleteAction();
    }


    public function findModel($id)
    {
        $model = IeltsQuestionGroup::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }
}