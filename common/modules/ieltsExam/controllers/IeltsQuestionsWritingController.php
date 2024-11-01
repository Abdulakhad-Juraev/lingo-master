<?php

namespace common\modules\ieltsExam\controllers;

use common\modules\ieltsExam\models\IeltsQuestions;
use common\modules\ieltsExam\models\search\IeltsQuestionsSearch;
use common\modules\toeflExam\models\EnglishExam;
use frontend\web\controllers\BaseController;
use soft\web\SoftController;
use Yii;

class IeltsQuestionsWritingController extends BaseController
{
    public function actionIndex($id)
    {
        $model = EnglishExam::findModel($id);
        $query = IeltsQuestions::find()
            ->andWhere(['exam_id' => $id])
            ->andWhere(['group_type' => IeltsQuestions::TYPE_WRITING_GROUP]);
        $searchModel = new IeltsQuestionsSearch();
        $dataProvider = $searchModel->search($query);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->ajaxCrud($model)->viewAction();
    }

    public function actionCreate($id)
    {
        $model = new IeltsQuestions([
            'exam_id' => $id,
            'type_id' => IeltsQuestions::TYPE_TEXT,
            'group_type' => IeltsQuestions::TYPE_WRITING_GROUP
        ]);
        $model->scenario = IeltsQuestions::SCENARIO_WRITING;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $id]);
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->group_type = IeltsQuestions::TYPE_WRITING_GROUP;
        if (!$model->getIsUpdatable()) {
            forbidden();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->exam_id]);
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $examId = $model->exam_id;

        if (!$model->getIsDeletable()) {
            forbidden();
        }
        $model->delete();
        return $this->redirect(['index', 'id' => $examId]);
    }

    public function findModel($id)
    {
        $model = IeltsQuestions::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }
}