<?php

namespace common\modules\usermanager\controllers;

use common\models\ImportExcel;
use common\models\search\BalanceSearch;
use common\modules\testmanager\models\search\TestResultSearch;
use common\modules\testmanager\models\TestResult;
use common\modules\usermanager\models\Balance;
use common\modules\usermanager\models\search\StudentSearch;
use common\modules\usermanager\models\search\UserDeviceSearch;
use common\modules\usermanager\models\search\UserPaymentSearch;
use common\modules\usermanager\models\Student;
use common\modules\usermanager\models\User;
use common\modules\usermanager\models\UserDevice;
use common\modules\usermanager\models\UserPayment;
use frontend\web\controllers\BaseController;
use Yii;
use yii\base\Exception;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class StudentController extends BaseController
{
    public function actionIndex(): string
    {
        $searchModel = new StudentSearch();
        $query = Student::find()
            ->andWhere(['not', ['type_id' => null]])
            ->andWhere(['!=', 'status', Student::STATUS_DELETED])
            ->andWhere(['!=', 'status', Student::STATUS_INACTIVE])
            ->andWhere(['type_id' => Student::TYPE_ID_STUDENT]);
        $dataProvider = $searchModel->search($query);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }


    public function actionArchiveIndex()
    {
        $searchModel = new StudentSearch();
        $query = Student::find()
            ->andWhere(['not', ['type_id' => null]])
            ->andWhere(['status' => Student::STATUS_INACTIVE])
            ->andWhere(['!=', 'status', Student::STATUS_DELETED])
            ->andWhere(['type_id' => Student::TYPE_ID_STUDENT]);
        $dataProvider = $searchModel->search($query);
        return $this->render('archive-index', [
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
        $model = new Student([
            'type_id' => User::TYPE_ID_STUDENT,
            'status' => Student::STATUS_ACTIVE,
            'is_accepted_student' => true
        ]);
        $model->scenario = Student::SCENARIO_CREATE_BY_STUDENT;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            $model->auth_key = Yii::$app->security->generateRandomString();
            if ($model->save()) {
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
        $model = Student::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (!empty($model->password)) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
                $model->auth_key = Yii::$app->security->generateRandomString();
            }
            $model->username = strtr($model->username, [
                ')' => '',
                '(' => ''
            ]);
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
        $model = Student::find()->andWhere([
            '!=', 'status', Student::STATUS_DELETED
        ])->andWhere(['id' => $id])->one();
        if (!$model) {
            not_found('Foydalanuvchi topilmadi');
        }
        $model->username = $model->username . '-' . $model->id;
        $model->status = Student::STATUS_DELETED;
        $model->save();
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = Student::findOne(['id' => $id]);
        return $this->render('view', [
            'model' => $model,
        ]);
    }


    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionChange($id)
    {
        $model = $this->findModel($id);

        if ($model->status == Student::STATUS_ACTIVE) {
            $model->status = Student::STATUS_INACTIVE;
        } else {
            $model->status = Student::STATUS_ACTIVE;
        }
        $model->save(false);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord
     * @throws yii\web\NotFoundHttpException
     */
    public function findModel($id)
    {
        $model = User::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }


    /**
     * @param $id
     * @return string
     */
    public function actionUserDevice($id)
    {
        $model = User::findOne($id);
        $searchModel = new UserDeviceSearch();
        $query = UserDevice::find()->andWhere(['user_id' => $id]);
        $dataProvider = $searchModel->search($query);
        return $this->render('user-device', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUserPayment($id)
    {
        $model = User::findOne($id);
        $searchModel = new UserPaymentSearch();
        $query = UserPayment::find()->andWhere(['user_id' => $id]);
        $dataProvider = $searchModel->search($query);
        return $this->render('user-payment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    public function actionTestResult($id): string
    {
        $model = Student::findOne($id);
        $searchModel = new TestResultSearch();

        $query = TestResult::find()
            ->andWhere(['user_id' => $id]);

        $dataProvider = $searchModel->search($query);

        return $this->render('user-test-result', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    public function actionImportStudent()
    {
        $model = new ImportExcel();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                $model->file->saveAs('@frontend/web/uploads/excelFile/' . $model->file->baseName . '.' . $model->file->extension);
                $fileName = Yii::getAlias('@frontend/web/uploads/excelFile/') . $model->file->baseName . '.' . $model->file->extension;
                $fileType = $model->file->extension;
                $errors = $model->processExcel($fileName, $fileType, 'import');
                Yii::$app->session->setFlash('errors', $errors);
                return $this->redirect(['student/index']);
            }
        }
        return $this->render('import', [
            'model' => $model,
        ]);
    }

    public function actionUpdateStudent()
    {
        $model = new ImportExcel();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                $model->file->saveAs('@frontend/web/uploads/excelFile/' . $model->file->baseName . '.' . $model->file->extension);
                $fileName = Yii::getAlias('@frontend/web/uploads/excelFile/') . $model->file->baseName . '.' . $model->file->extension;
                $fileType = $model->file->extension;
                $errors = $model->processExcel($fileName, $fileType, 'update');
                Yii::$app->session->setFlash('errors', $errors);
                return $this->redirect(['student/index']);
            }
        }
        return $this->render('import', [
            'model' => $model,
        ]);
    }

    public function actionStudentDelete()
    {
        $model = new ImportExcel();
        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->validate()) {
                $model->file->saveAs('@frontend/web/uploads/excelFile/' . $model->file->baseName . '.' . $model->file->extension);
                $fileName = Yii::getAlias('@frontend/web/uploads/excelFile/') . $model->file->baseName . '.' . $model->file->extension;
                $fileType = $model->file->extension;
                $errors = $model->processExcel($fileName, $fileType, 'delete');
                Yii::$app->session->setFlash('errors', $errors);
                return $this->redirect(['student/index']);
            }
        }
        return $this->render('update-import', [
            'model' => $model,
        ]);
    }

}