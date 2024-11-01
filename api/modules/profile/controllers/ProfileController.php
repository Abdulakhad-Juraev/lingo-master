<?php

namespace api\modules\profile\controllers;

use api\controllers\ApiBaseController;
use api\models\User;
use api\modules\profile\models\UpdatePasswordForm;
use Yii;
use yii\web\UploadedFile;

class ProfileController extends ApiBaseController
{
    /**
     * @var string[]
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
    /**
     * @var bool
     */
    public $authRequired = true;

    /**
     * @return array
     */
    public function actionInfo(): array
    {
        return $this->success(Yii::$app->user->identity);
    }

    /**
     * @return array
     */
    public function actionUpdatePassword(): array
    {
        $model = new UpdatePasswordForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->changePassword()) {
            return $this->success();
        }
        return $this->error($model->firstErrorMessage);
    }

    public function actionUpdate(): array
    {
        /** @var User $model */
        $model = Yii::$app->user->identity;
        $model->scenario = User::SCENARIO_UPDATE;
        $old_img = $model->photo;
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            $image = UploadedFile::getInstanceByName('photo');
            $url = Yii::getAlias('@frontend/web/uploads/user/' . $old_img);
            if ($image) {
                $image->saveAs('@frontend/web/uploads/user/' . 'user' . time() . '.' . $image->extension);
                $model->photo = 'user' . time() . '.' . $image->extension;
                if (is_file($url)) {
                    unlink($url);
                }
            } else {
                $model->photo = $old_img;
            }
            $model->born_date = Yii::$app->formatter->asDate($model->born_date, 'php:Y-m-d');
            $model->update();

            return $this->success($model);
        } else {
            return $this->error($model->firstErrorMessage);
        }
    }

}