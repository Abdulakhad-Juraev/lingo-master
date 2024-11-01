<?php

namespace common\modules\toeflExam\controllers;

use common\modules\toeflExam\models\EnglishExam;
use common\modules\toeflExam\models\search\ToeflReadingGroupSearch;
use common\modules\toeflExam\models\ToeflListeningGroup;
use common\modules\toeflExam\models\ToeflReadingGroup;
use frontend\web\controllers\BaseController;
use soft\web\SoftController;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class ToeflReadingGroupController extends BaseController
{


    /**
     * @return mixed
     */
    public function actionIndex($id)
    {
        $group = EnglishExam::findModel($id);
        $query = ToeflReadingGroup::find()
            ->andWhere(['exam_id' => $id]);
        $searchModel = new ToeflReadingGroupSearch();
        $dataProvider = $searchModel->search($query);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'group' => $group
        ]);
    }

    /**
     * @param string $id
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
    public function actionCreate($id)
    {
        $model = new ToeflReadingGroup([
            'exam_id' => $id,
            'status' => ToeflListeningGroup::STATUS_ACTIVE
        ]);
        return $this->ajaxCrud($model)->createAction();
    }

    /**
     * @param string $id
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
     * @param string $id
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
     * @return ToeflReadingGroup
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = ToeflReadingGroup::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }
}
