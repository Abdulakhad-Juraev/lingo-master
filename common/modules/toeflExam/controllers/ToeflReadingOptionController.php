<?php

namespace common\modules\toeflExam\controllers;

use common\modules\toeflExam\models\search\ToeflOptionSearch;
use common\modules\toeflExam\models\ToeflOption;
use common\modules\toeflExam\models\ToeflQuestion;
use common\modules\toeflExam\models\ToeflReadingGroup;
use frontend\web\controllers\BaseController;
use Yii;
use yii\web\NotFoundHttpException;

class ToeflReadingOptionController extends BaseController
{
    public function actionIndex($id)
    {
        $model = ToeflReadingGroup::findModel($id);
        $query = ToeflQuestion::find()->andWhere(['reading_group_id' => $id]);
        $searchModel = new ToeflOptionSearch();
        $dataProvider = $searchModel->search($query);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    public function actionCreate($id)
    {
        /** @var ToeflReadingGroup $toefl_listening */
        $toefl_listening = ToeflReadingGroup::findActiveModel($id);
        $model = new ToeflQuestion(
            [
                'exam_id' => $toefl_listening->exam_id,
                'reading_group_id' => $toefl_listening->id,
            ]
        );
        $modelsOption = [new ToeflOption()];
        $model->scenario = ToeflQuestion::SCENARIO_READING;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->insertMultiple($modelsOption)) {
                return $this->redirect(['toefl-reading-option/index', 'id' => $toefl_listening->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'modelsOption' => $modelsOption,
        ]);
    }

    public function actionUpdate($id)
    {

        $model = ToeflQuestion::findModel($id);
        $exam = $model->exam;
        $modelsOption = $model->toeflOptions;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->updateMultiple($modelsOption)) {
                return $this->redirect(['toefl-reading-option/index', 'id' => $model->reading_group_id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'exam' => $exam,
            'modelsOption' => empty($modelsOption) ? [new ToeflOption()] : $modelsOption,
        ]);
    }

    public function actionDelete($id): \yii\web\Response
    {
        $model = ToeflQuestion::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $readingGroupId = $model->reading_group_id;
        $model->delete();
        return $this->redirect(['toefl-reading-option/index', 'id' => $readingGroupId]);
    }
}