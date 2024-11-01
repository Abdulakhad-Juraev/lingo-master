<?php

namespace backend\modules\profilemanager\controllers;

use backend\modules\profilemanager\models\ChangePasswordForm;
use backend\modules\profilemanager\models\ProfileUser;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Default controller for the `profilemanager` module
 */
class DefaultController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionChangeLogin()
    {
        $model = ProfileUser::getUserModel();
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('app', 'Page not found'));
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->photo = UploadedFile::getInstance($model, 'photo');
            if ($model->validate() && $model->upload() && $model->save()) {
                \Yii::$app->session->setFlash("success", "Ma'lumotlar saqlandi.");
                return $this->refresh();
            }
            Yii::$app->session->setFlash('success', "Shaxsiy ma'lumotlaringiz muvaffaqiyatli o'zgartirildi!");
            return $this->redirect(['index']);
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->savePassword()) {

            Yii::$app->session->setFlash('success', "Parolingiz muvaffaqiyatli o'zgartirildi!");
            return $this->redirect(['index']);

        }
        return $this->render('changePassword', ['model' => $model]);
    }
}
