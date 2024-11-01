<?php
/*
 *  @author Shukurullo Odilov
 *  @link telegram: https://t.me/yii2_dasturchi
 *  @date 19.07.2021, 7:17
 */

namespace common\modules\testmanager\controllers;

use common\modules\testmanager\models\Option;
use common\modules\testmanager\models\Question;
use common\modules\testmanager\models\search\QuestionSearch;
use common\modules\testmanager\models\Test;
use frontend\web\controllers\BaseController;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * QuestionController implements the CRUD actions for Question model.
 */
class QuestionController extends BaseController
{


    /**
     * Lists all Question models.
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($test_id)
    {
        $test = $this->findTestModel($test_id);
        $searchModel = new QuestionSearch();
        $searchModel->test_id = $test->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'test' => $test,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Question model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCreate($test_id)
    {
        $test = $this->findTestModel($test_id);
        $model = new Question([
            'test_id' => $test_id,
        ]);
        $modelsOption = [new Option()];

        if ($model->load(Yii::$app->request->post())) {

            if ($model->insertMultiple($modelsOption)) {
                return $this->redirect(['index', 'test_id' => $test->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'test' => $test,
            'modelsOption' => $modelsOption,
        ]);
    }

    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $test = $model->test;

        $modelsOption = $model->options;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->updateMultiple($modelsOption)) {
                return $this->redirect(['index', 'test_id' => $test->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'test' => $test,
            'modelsOption' => empty($modelsOption) ? [new Option()] : $modelsOption,
        ]);
    }


    /**
     * Deletes an existing Question model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id): mixed
    {
        $model = $this->findModel($id);
        $test_id = $model->test_id;
        $model->status = Question::STATUS_DELETE;
        $model->save();
        return $this->redirect(['index', 'test' => $test_id]);
    }

    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Test|null the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findTestModel($id)
    {
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
