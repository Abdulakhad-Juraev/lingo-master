<?php

namespace common\modules\toeflExam\controllers;

use common\modules\toeflExam\models\search\ToeflOptionSearch;
use common\modules\toeflExam\models\ToeflListeningGroup;
use common\modules\toeflExam\models\ToeflOption;
use common\modules\toeflExam\models\ToeflQuestion;
use frontend\web\controllers\BaseController;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ToeflListeningOptionController extends BaseController
{
    public function actionIndex($id)
    {
        $model = ToeflListeningGroup::findModel($id);
        $query = ToeflQuestion::find()->andWhere(['listening_group_id' => $id]);
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
        /** @var ToeflListeningGroup $toefl_listening */
        $toefl_listening = ToeflListeningGroup::findActiveModel($id);
        $model = new ToeflQuestion(
            [
                'exam_id' => $toefl_listening->exam_id,
                'listening_group_id' => $toefl_listening->id,
                'type_id' => ToeflQuestion::TYPE_LISTENING,
                'test_type_id' => $toefl_listening->type_id,
            ]
        );
        $model->value = (int)$model->lastQuestion() + 1;
        $modelsOption = [new ToeflOption()];
        $model->scenario = ToeflQuestion::SCENARIO_LISTENING;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->insertMultiple($modelsOption)) {
                return $this->redirect(['toefl-listening-option/index', 'id' => $toefl_listening->id]);
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
                return $this->redirect(['toefl-listening-option/index', 'id' => $model->listening_group_id]);
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
    public function actionDelete($id)
    {
        $model = ToeflQuestion::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $listeningGroupId = $model->listening_group_id;
        $model->delete();
        return $this->redirect(['toefl-listening-option/index', 'id' => $listeningGroupId]);
    }

}