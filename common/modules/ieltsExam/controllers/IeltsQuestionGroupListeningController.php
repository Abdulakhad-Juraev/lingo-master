<?php

namespace common\modules\ieltsExam\controllers;

use common\modules\ieltsExam\models\IeltsQuestionGroup;
use common\modules\ieltsExam\models\search\IeltsQuestionGroupSearch;
use common\modules\toeflExam\models\EnglishExam;
use frontend\web\controllers\BaseController;
use Yii;
use yii\web\UploadedFile;

class IeltsQuestionGroupListeningController extends BaseController
{

    public function actionIndex($id)
    {
        $exam = EnglishExam::findModel($id);
        $query = IeltsQuestionGroup::find()->andWhere(['type_id' => IeltsQuestionGroup::TYPE_LISTENING]);
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
            'type_id' => IeltsQuestionGroup::TYPE_LISTENING,
            'status' => IeltsQuestionGroup::STATUS_ACTIVE
        ]);
        $model->scenario = IeltsQuestionGroup::SCENARIO_LISTENING;
        if ($model->load(Yii::$app->request->post())) {
            $model->audioFile = UploadedFile::getInstance($model, 'audioFile');
            if ($model->upload()) {
                Yii::$app->session->setFlash('success', t('Audio file uploaded successfully'));
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
            return $this->forbidden();
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->scenario = IeltsQuestionGroup::SCENARIO_LISTENING;
            $model->audioFile = UploadedFile::getInstance($model, 'audioFile');
            if ($model->upload()) {
                Yii::$app->session->setFlash('success', t('Audio file updated successfully'));
                return $this->redirect(['index', 'id' => $model->exam_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'exam' => $model->exam,
        ]);
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
