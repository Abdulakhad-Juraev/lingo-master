<?php

namespace common\modules\ieltsExam\controllers;

use common\modules\ieltsExam\models\IeltsCheckResult;
use common\modules\ieltsExam\models\IeltsResult;
use common\modules\ieltsExam\models\IeltsResultItem;
use common\modules\ieltsExam\models\search\IeltsResultItemSearch;
use common\modules\ieltsExam\models\search\IeltsResultSearch;
use frontend\web\controllers\BaseController;
use soft\helpers\Html;
use Yii;
use Yii\web\NotFoundHttpException;
use yii\web\Response;

class IeltsCheckResultController extends BaseController
{
    public function actionIndex()
    {
        $query = IeltsResult::find()
            ->andWhere(['ielts_result.status' => IeltsResult::STATUS_INACTIVE])
            ->andWhere([
                'or',
                ['is', 'ielts_result.speaking_score', null],
                ['is', 'ielts_result.writing_score', null],
            ])
        ->orderBy('created_at DESC');
        $searchModel = new IeltsResultSearch();
        $dataProvider = $searchModel->search($query);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGradeSpeaking($id)
    {
        /** @var IeltsResult $result */

        $result = IeltsResult::findOne($id);
        if (!$result) {
            forbidden('Natija topilamdi');
        }
        $model = new IeltsCheckResult();
        $model->scenario = IeltsCheckResult::SCENARIO_SPEAKING;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $result->speaking_score = $model->speaking_score;
            $result->save();
            return [
                'forceReload' => '#crud-datatable-pjax',
                'forceClose' => true,
            ];
        }
        return [
            'title' => "Yangi qo'shish",
            'content' => $this->renderAjax('speaking', [
                'model' => $model,
            ]),
            'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit"])

        ];
    }

    public function actionGradeWriting($id)
    {
        /** @var IeltsResult $result */

        $result = IeltsResult::findOne($id);
        if (!$result) {
            forbidden('Natija topilamdi');
        }
        $model = new IeltsCheckResult();
        $model->scenario = IeltsCheckResult::SCENARIO_WRITING;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $result->writing_score = $model->writing_score;
            $result->save();
            return [
                'forceReload' => '#crud-datatable-pjax',
                'forceClose' => true,
            ];
        }
        return [
            'title' => "Yangi qo'shish",
            'content' => $this->renderAjax('writing', [
                'model' => $model,
            ]),
            'footer' => Html::button('Jarayoni tugatish', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                Html::button('Saqlash', ['class' => 'btn btn-primary', 'type' => "submit"])

        ];
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionDetail($id)
    {
        $model = IeltsResult::findModel($id);
        $query = IeltsResultItem::find()
            ->andWhere(['result_id' => $model->id])
            ->andWhere(['type_id' => IeltsResultItem::TYPE_WRITING]);
        $searchModel = new IeltsResultItemSearch();
        $dataProvider = $searchModel->search($query);
        return $this->render('detail', ['model' => $model, 'dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }
    public function actionSpeakingDetail($id)
    {
        $model = IeltsResult::findModel($id);
        $query = IeltsResultItem::find()
            ->andWhere(['result_id' => $model->id])
            ->andWhere(['type_id' => IeltsResultItem::TYPE_SPEAKING]);
        $searchModel = new IeltsResultItemSearch();
        $dataProvider = $searchModel->search($query);
        return $this->render('speaking-detail', ['model' => $model, 'dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
    }

}