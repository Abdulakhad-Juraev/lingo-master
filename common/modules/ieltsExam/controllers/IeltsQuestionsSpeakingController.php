<?php

namespace common\modules\ieltsExam\controllers;

use common\modules\ieltsExam\models\IeltsQuestions;
use common\modules\ieltsExam\models\search\IeltsQuestionsSearch;
use common\modules\toeflExam\models\EnglishExam;
use frontend\web\controllers\BaseController;
use soft\web\SoftController;
use Yii;
use yii\web\UploadedFile;

class IeltsQuestionsSpeakingController extends BaseController
{
    public function actionIndex($id)
    {
        $model = EnglishExam::findModel($id);
        $searchModel = new IeltsQuestionsSearch();
        $query = IeltsQuestions::find()->andWhere(['group_type' => IeltsQuestions::TYPE_SPEAKING_GROUP]);
        $dataProvider = $searchModel->search($query);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionCreate($id)
    {
        $model = new IeltsQuestions([
            'exam_id' => $id,
            'type_id' => IeltsQuestions::TYPE_AUDIO,
            'group_type' => IeltsQuestions::TYPE_SPEAKING_GROUP,
        ]);
        $model->scenario = IeltsQuestions::SCENARIO_SPEAKING;
        if ($model->load(Yii::$app->request->post())) {
            $model->audioFile = UploadedFile::getInstance($model, 'audioFile');
            if ($model->upload()) {
                return $this->redirect(['ielts-questions-speaking/index', 'id' => $model->exam_id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = IeltsQuestions::SCENARIO_SPEAKING;
        $model->group_type = IeltsQuestions::TYPE_SPEAKING_GROUP;

        if (!$model->getIsUpdatable()) {
            return $this->forbidden();
        }

        if ($model->load(Yii::$app->request->post())) {
            // Handle file upload
            $model->audioFile = UploadedFile::getInstance($model, 'audioFile');

            // If a new file is uploaded, attempt to save it
            if ($model->audioFile && $model->upload()) {
                return $this->redirect(['ielts-questions-speaking/index', 'id' => $model->exam_id]);
            }

            // If no new file is uploaded, proceed with saving the rest of the model
            if (!$model->audioFile && $model->save()) {
                return $this->redirect(['index', 'id' => $model->exam_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
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