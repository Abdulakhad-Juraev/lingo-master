<?php

namespace common\modules\ieltsExam\controllers;

use common\modules\toeflExam\models\EnglishExam;
use frontend\web\controllers\BaseController;
use Yii;
use common\modules\ieltsExam\models\IeltsQuestionGroup;
use common\modules\ieltsExam\models\search\IeltsQuestionGroupSearch;
use soft\web\SoftController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class IeltsQuestionGroupController extends BaseController
{

    /**
     * @return mixed
     */
    public function actionIndex($id)
    {
        $exam = EnglishExam::findModel($id);
        $query = IeltsQuestionGroup::find()
            ->andWhere(['type_id' => IeltsQuestionGroup::TYPE_LISTENING]);
        $searchModel = new IeltsQuestionGroupSearch();
        $dataProvider = $searchModel->search($query);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'exam' => $exam
        ]);
    }

    /**
     * @param integer $id
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
    public function actionCreateListening()
    {
        $model = new IeltsQuestionGroup();
        $model->scenario = IeltsQuestionGroup::SCENARIO_LISTENING;
        return $this->ajaxCrud($model)->createAction();
    }

    /**
     * @param integer $id
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
     * @param integer $id
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
     * @return IeltsQuestionGroup
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = IeltsQuestionGroup::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }
}
