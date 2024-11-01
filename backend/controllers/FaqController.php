<?php

namespace backend\controllers;

use Yii;
use common\models\Faq;
use common\models\search\FaqSearch;
use soft\web\SoftController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class FaqController extends SoftController
{

    /**
    * {@inheritdoc}
    */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'bulk-delete' => ['POST'],
                ],
            ],
            /*'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ]*/
        ];
    }

    /**
    * @return mixed
    */
    public function actionIndex()
    {
        $searchModel = new FaqSearch();
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
    public function actionCreate()
    {
        $model = new Faq();
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
    * @return Faq
    * @throws yii\web\NotFoundHttpException
    */
    public function findModel($id)
    {
        $model = Faq::find()->andWhere(['id' => $id])->one();
        if ($model == null){
            not_found();
        }
        return $model;
    }
}
