<?php

namespace common\modules\toeflExam\controllers;

use common\modules\toeflExam\models\EnglishExam;
use common\modules\toeflExam\models\search\ToeflListeningGroupSearch;
use common\modules\toeflExam\models\ToeflListeningGroup;
use frontend\web\controllers\BaseController;
use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class ToeflListeningGroupController extends BaseController
{
    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($id)
    {
        $group = EnglishExam::findModel($id);
        $query = ToeflListeningGroup::find()
            ->andWhere(['exam_id' => $id]);
        $searchModel = new ToeflListeningGroupSearch();
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
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionCreate($id)
    {
        $group = EnglishExam::findModel($id);
        $model = new ToeflListeningGroup([
            'exam_id' => $id
        ]);
        if ($model->load(Yii::$app->request->post())) {
            $model->audioFile = UploadedFile::getInstance($model, 'audioFile');
            if ($model->upload()) {
                Yii::$app->session->setFlash('success', 'Fayl muvaffaqiyatli yuklandi va saqlandi.');
                return $this->redirect(['index', 'id' => $id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'group' => $group
        ]);
    }


    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->audioFile = UploadedFile::getInstance($model, 'audioFile');
            if ($model->upload()) {
                Yii::$app->session->setFlash('success', 'Fayl muvaffaqiyatli yuklandi va saqlandi.');
                return $this->redirect(['index', 'id' => $id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
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
     * @return array|ActiveRecord|null
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = ToeflListeningGroup::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }
}
