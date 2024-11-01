<?php

namespace common\modules\auth\controllers;

use common\modules\auth\models\AuthItem;
use common\modules\auth\models\AuthItemChild;
use common\modules\auth\models\search\AuthItemSearch;
use frontend\web\controllers\BaseController;
use Throwable;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class RollController extends BaseController
{
    /**
     * {@inheritdoc}
     */


    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $query = AuthItem::find()
            ->andWhere(['type' => AuthItem::TYPE_ONE]);

        $dataProvider = $searchModel->search($query);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionCreate()
    {
        $model = new AuthItem([
            'type' => AuthItem::TYPE_ONE
        ]);

        return $this->ajaxCrud($model)->createAction();
    }

    /**
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Exception
     */
    public function actionUpdate($name)
    {
        $model = $this->findModel($name);
        if (!$model->getIsUpdatable()) {
            forbidden();
        }
        return $this->ajaxCrud($model)->updateAction();
    }

    /**
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($name)
    {
        $model = $this->findModel($name);
        return $this->ajaxCrud->viewAction($model);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($name)
    {
        $model = AuthItem::find()
            ->andWhere(['name' => $name])
            ->andWhere(['not in', 'name', ['teacher', 'student', 'user', 'admin']])
            ->one();
        if (!$model) {
            forbidden('O\'chirish mumkin emas');
        }
        if (!$model->getIsDeletable()) {
            forbidden();
        }
        $model->delete();
        return $this->ajaxCrud->closeModalResponse();
    }

    /**
     * @param $name
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPermissions($name)
    {
        $roll = $this->findModel($name);

        $items = AuthItem::find()
            ->andWhere(['type' => AuthItem::TYPE_THREE])
            ->all();
        return $this->render('permission', [
            'roll' => $roll,
            'items' => $items,
        ]);
    }

    /**
     * @return Response
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionPermissionCreate()
    {

        $selects = Yii::$app->request->post('items');
        $roll = $this->findModel(Yii::$app->request->post('roll-name'));
        $old_items = AuthItemChild::find()->andWhere(['parent' => $roll->name])->all();

        foreach ($old_items as $old_item) {
            $old_item->delete();
        }
        if ($selects) {
            foreach ($selects as $select) {
                $auth_child = new AuthItemChild();
                $auth_child->parent = $roll->name;
                $auth_child->child = $select;
                $auth_child->save(false);
            }
        }
        Yii::$app->session->setFlash('success', 'Муваффақиятли сақланди');
        return $this->redirect('index');
    }

    /**
     * @param $name
     * @return array|AuthItem|ActiveRecord
     * @throws NotFoundHttpException
     */
    public function findModel($name)
    {
        $model = AuthItem::find()->andWhere(['name' => $name])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }
}