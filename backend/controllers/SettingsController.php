<?php

namespace backend\controllers;

use common\models\Settings;
use frontend\web\controllers\BaseController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * SettingController implements the CRUD actions for Setting model.
 */
class SettingsController extends BaseController
{
    /**
     * Lists all Setting models.
     * @return string
     */
    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Settings::find()
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Setting model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Setting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            \Yii::$app->cache->flush();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Setting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Settings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Settings
    {
        if (($model = Settings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return \yii\web\Response
     */
    public function actionClearCache(): \yii\web\Response
    {
        $cleared = \Yii::$app->cache->flush();
        if ($cleared) {
            \Yii::$app->session->setFlash('success', 'Kesh tozalandi');
        } else {
            \Yii::$app->session->setFlash('error', 'Kesh tozalashda xatolik');
        }

        return $this->redirect(['index']);
    }
}
