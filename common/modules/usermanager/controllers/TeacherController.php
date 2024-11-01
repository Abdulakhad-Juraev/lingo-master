<?php

namespace common\modules\usermanager\controllers;

use common\modules\usermanager\models\search\UserSearch;
use common\modules\usermanager\models\Teacher;
use common\modules\usermanager\models\TeacherForm;
use common\modules\usermanager\models\User;
use frontend\web\controllers\BaseController;
use Yii;
use yii\base\Exception;
use yii\web\NotFoundHttpException;

class TeacherController extends BaseController
{
    public function actionIndex(): string
    {
        $searchModel = new UserSearch();
        $query = User::find()
            ->andWhere(['not', ['type_id' => null]])
            ->andWhere(['!=', 'status', Teacher::STATUS_DELETED])
            ->andWhere(['type_id' => User::TYPE_ID_TEACHER]);
        $dataProvider = $searchModel->search($query);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function actionCreate()
    {
        $model = new Teacher([
            'type_id' => Teacher::TYPE_ID_TEACHER,
            'status' => Teacher::STATUS_ACTIVE
        ]);
        $model->scenario = Teacher::SCENARIO_CREATE_BY_TEACHER;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->username = Teacher::getClearPhone($model->username);
            if ($model->save()) {
                $roleNames[] = 'teacher';
                $model->assignNewRoles($roleNames);
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model
                ]);
            }
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Teacher::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $roleNames[] = 'teacher';
            if (!empty($model->password)) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                $model->auth_key = Yii::$app->security->generateRandomString();
            }
            $model->username = Teacher::getClearPhone($model->username);
            if ($model->save(false)) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model
        ]);

    }

    public function actionDelete($id): \yii\web\Response
    {
        $model = Teacher::find()->andWhere([
            '!=', 'status', Teacher::STATUS_DELETED
        ])->andWhere(['id' => $id])->one();
        if (!$model) {
            not_found('Foydalanuvchi topilmadi');
        }
        $model->username = $model->username . '-' . $model->id;
        $model->status = Teacher::STATUS_DELETED;
        $model->save();
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = Teacher::findOne(['id' => $id]);
        return $this->render('view', [
            'model'=>$model,
        ]);
    }


    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionChange($id)
    {
        $model = $this->findModel($id);

        if ($model->status == Teacher::STATUS_ACTIVE) {
            $model->status = Teacher::STATUS_INACTIVE;
        } else {
            $model->status = Teacher::STATUS_ACTIVE;
        }
        $model->save(false);
        return $this->redirect(Yii::$app->request->referrer);
    }
    /**
     * @param $id
     * @return Language
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = User::find()->andWhere(['id' => $id])->one();
        if ($model == null){
            not_found();
        }
        return $model;
    }
}