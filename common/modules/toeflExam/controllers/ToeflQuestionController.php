<?php

namespace common\modules\toeflExam\controllers;

use common\modules\toeflExam\models\EnglishExam;
use common\modules\toeflExam\models\search\ToeflQuestionSearch;
use common\modules\toeflExam\models\ToeflOption;
use common\modules\toeflExam\models\ToeflQuestion;
use frontend\web\controllers\BaseController;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ToeflQuestionController extends BaseController
{

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($id)
    {
        $model = $this->findExamModel($id);
        $query = ToeflQuestion::find()->andWhere(['exam_id' => $id])->andWhere(['type_id' => ToeflQuestion::TYPE_WRITING]);
        $searchModel = new ToeflQuestionSearch();
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

    //<editor-fold desc="Writing Actions" defaultstate="collapsed">

    /**
     * @param $exam_id
     * @return string|Response
     * @throws InvalidConfigException
     * @throws NotFoundHttpException
     */
    public function actionCreate($exam_id)
    {
        $exam = $this->findExamModel($exam_id);
        $model = new ToeflQuestion(
            [
                'exam_id' => $exam_id,
                'type_id' => ToeflQuestion::TYPE_WRITING
            ]
        );
        $modelsOption = [new ToeflOption()];
        $model->scenario = ToeflQuestion::SCENARIO_WRITING;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->insertMultiple($modelsOption)) {
                return $this->redirect(['index', 'id' => $exam_id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'exam' => $exam,
            'modelsOption' => $modelsOption,
        ]);

    }


    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $exam = $model->exam;
        $modelsOption = $model->toeflOptions;
        $model->scenario = ToeflQuestion::SCENARIO_WRITING;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->updateMultiple($modelsOption)) {
                return $this->redirect(['index', 'id' => $exam->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'exam' => $exam,
            'modelsOption' => empty($modelsOption) ? [new ToeflOption()] : $modelsOption,
        ]);
    }


    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDeleteWriting($id)
    {
        $model = $this->findModel($id);
        if ($model->type_id !== ToeflQuestion::TYPE_WRITING) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $examId = $model->exam_id;
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model->delete();

        return $this->redirect(['index', 'id' => $examId]);
    }

    //</editor-fold>

    /**
     * @param $id
     * @return ToeflQuestion
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = ToeflQuestion::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }

    /**
     * @param $id
     * @return EnglishExam|null
     * @throws NotFoundHttpException
     */
    protected function findExamModel($id)
    {
        if (($model = EnglishExam::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
