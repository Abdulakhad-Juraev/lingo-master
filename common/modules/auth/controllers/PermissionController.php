<?php

namespace common\modules\auth\controllers;

use common\modules\auth\models\AuthItem;
use common\modules\auth\models\AuthItemChild;
use common\modules\auth\models\AuthItemThree;
use common\modules\auth\models\search\AuthItemSearch;
use frontend\web\controllers\BaseController;
use soft\helpers\ArrayHelper;
use soft\web\SoftController;
use soft\widget\dynamicform\DynamicFormModel;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PermissionController extends BaseController
{


    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $query = AuthItem::find()
            ->andWhere(['type' => AuthItem::TYPE_THREE]);
        $dataProvider = $searchModel->search($query);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $model = new AuthItem([
            'type' => AuthItem::TYPE_THREE
        ]);
        $dform = [new AuthItemThree()];
        if ($model->load(Yii::$app->request->post())) {

            $dform = AuthItemThree::createMultiple(AuthItemThree::classname());
            AuthItemThree::loadMultiple($dform, Yii::$app->request->post());

            $valid = $model->validate();
            $valid = AuthItemThree::validateMultiple($dform) && $valid;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($dform as $item) {
                            $item->name = $model->name . '/' . $item->name;
                            $item->type = AuthItemThree::TYPE_TWO;
                            if (!($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            $childModel = new AuthItemChild();
                            $childModel->parent = $model->category_id;
                            $childModel->child = $item->name;
                            $childModel->save();
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'name' => $model->name]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
            'dform' => $dform,
        ]);
    }


    public function actionCreatePermission($name)
    {
        $model = $this->findModel($name);
        $item = new AuthItem();
        $old_iteam_child = AuthItemChild::find()->andWhere(['like', 'child', $model->name])->one();
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($request->isGet) {
            return [
                'title' => 'Пермиссион қўшиш',
                'content' => $this->renderAjax('create-permission', [
                    'item' => $item,
                    'model' => $model,
                ]),
                'footer' => Html::button('Ёпиш', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"]) .
                    Html::button('Сақлаш', ['class' => 'btn btn-primary', 'type' => "submit"])
            ];
        } else {
            if ($item->load($request->post())) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $item->name = $model->name . '/' . $item->name;
                    $item->type = AuthItem::TYPE_TWO;
                    $item->save();
                    $childModel = new AuthItemChild();
                    $childModel->parent = $old_iteam_child->parent;
                    $childModel->child = $item->name;
                    $childModel->save();
                    $transaction->commit();
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'forceClose' => true,
                    ];
                } catch (Exception $e) {
                    dd($e->getMessage());
                    $transaction->rollBack();
                }

            }
        }
    }

    /**
     * @param $name
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($name)
    {
        $model = $this->findModel($name);
        $name=$name.'/';

        $model->category_id = AuthItemChild::find()
            ->andWhere(['like', 'child', $name])
            ->one()->parent;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {


                $authTypeTrees = AuthItem::find()
                    ->andWhere(['type' => AuthItem::TYPE_TWO])
                    ->andWhere(['like', 'name', $name])
                    ->all();

                foreach ($authTypeTrees as $authTypeTree) {
                    $oldName = explode('/', $authTypeTree->name);
                    $authTypeTree->name = $model->name . '/' . $oldName[1];
                    $authTypeTree->save();
                }
                $childs = AuthItemChild::find()
                    ->andWhere(['like', 'child', $model->name])
                    ->all();
                foreach ($childs as $child) {
                    $child->parent = $model->category_id;
                    $child->save();
                }
            }
            return $this->redirect(['view', 'name' => $model->name]);
        }
        return $this->render('_update_form', [
            'model' => $model
        ]);
    }

    /**
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($name)
    {
        $model = $this->findModel($name);
        $name = $name . '/';
        $actions = AuthItem::find()
            ->andFilterWhere(['like', 'name', $name])
            ->andWhere(['type' => AuthItem::TYPE_TWO]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $actions,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $name
     * @return array|AuthItem|\yii\db\ActiveRecord
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