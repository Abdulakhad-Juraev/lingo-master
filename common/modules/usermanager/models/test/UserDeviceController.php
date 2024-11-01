<?php



use common\modules\usermanager\controllers\Language;
use frontend\web\controllers\BaseController;
use Yii;

class UserDeviceController extends BaseController
{

    public function actionChange($id)
    {
        $model = $this->findModel($id);

        if ($model->status == UserDevice::STATUS_ACTIVE) {
            $model->status = UserDevice::STATUS_INACTIVE;
        } else {
            $model->status = UserDevice::STATUS_ACTIVE;
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
        $model = UserDevice::find()->andWhere(['id' => $id])->one();
        if ($model == null) {
            not_found();
        }
        return $model;
    }

}