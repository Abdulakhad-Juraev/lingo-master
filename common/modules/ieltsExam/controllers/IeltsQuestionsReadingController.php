<?php

namespace common\modules\ieltsExam\controllers;

use common\modules\ieltsExam\models\IeltsOptions;
use common\modules\ieltsExam\models\IeltsQuestionGroup;
use common\modules\ieltsExam\models\IeltsQuestions;
use common\modules\ieltsExam\models\search\IeltsQuestionsSearch;
use frontend\web\controllers\BaseController;
use soft\web\SoftController;
use Yii;

class IeltsQuestionsReadingController extends BaseController
{
    public function actionIndex($id)
    {
        $model = IeltsQuestionGroup::findModel($id);
        $searchModel = new IeltsQuestionsSearch();
        $query = IeltsQuestions::find()
            ->andWhere(['question_group_id' => $id])
            ->andWhere(['group_type' => IeltsQuestions::TYPE_READING_GROUP]);
        $dataProvider = $searchModel->search($query);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->ajaxCrud($model)->viewAction();
    }

    public function actionCreate($id)
    {
        $ielts_question_group = IeltsQuestionGroup::findActiveModel($id);
        $model = new IeltsQuestions([
            'question_group_id' => $ielts_question_group->id,
            'exam_id' => $ielts_question_group->exam_id,
            'group_type' => IeltsQuestions::TYPE_READING_GROUP
        ]);
        $modelsOption = [new IeltsOptions()];
        $model->scenario = IeltsQuestions::SCENARIO_READING;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->insertMultiple($modelsOption)) {
                return $this->redirect(['ielts-questions-reading/index', 'id' => $ielts_question_group->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'modelsOption' => $modelsOption,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = IeltsQuestions::findModel($id);
        $exam = $model->exam;
        $modelsOption = $model->ieltsOptions;
        $model->group_type = IeltsQuestions::TYPE_READING_GROUP;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->updateMultiple($modelsOption)) {
                return $this->redirect(['ielts-questions-reading/index', 'id' => $model->question_group_id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'exam' => $exam,
            'modelsOption' => empty($modelsOption) ? [new IeltsOptions()] : $modelsOption,
        ]);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $oldId = $model->question_group_id;
        if (!$model->getIsDeletable()) {
            forbidden();
        }
        if ($model->delete()) {
            Yii::$app->session->setFlash('success', 'Record deleted successfully.');
            return $this->redirect(['index', 'id' => $oldId]);
        } else {
            Yii::$app->session->setFlash('error', 'Failed to delete the record.');
            return $this->redirect(['index']);
        }
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