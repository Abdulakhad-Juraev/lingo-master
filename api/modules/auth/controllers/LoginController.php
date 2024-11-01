<?php

namespace api\modules\auth\controllers;

use api\controllers\ApiBaseController;
use api\models\User;
use api\modules\auth\models\LoginForm;
use api\modules\auth\models\LoginFormStudent;
use soft\helpers\Html;
use Yii;

class LoginController extends ApiBaseController
{
    /**
     * @return array
     */
    public function actionLogin(): array
    {
        $model = new LoginForm();
        if ($model->load($this->post(), '') && $model->validate()) {
            $user = $model->user;
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->save();
            return $this->success([
                'id' => $user->id,
                'username' => Html::encode($user->username),
                'full_name' => Html::encode($user->full_name),
                'born_date' => Yii::$app->formatter->asDate($user->born_date, 'php:d.m.Y'),
                'regionName' => $user->region->name_uz ?? '',
                'region_id' => $user->region_id,
                'districtName' => $user->district->name_uz ?? '',
                'district_id' => $user->district_id,
                'sexName' => $user->sexTypeName(),
                'imageUrl' => $user->getImageUrl(),
                'status' => $user->status,
                'statusName' => $user->statusName,
                'auth_key' => $user->auth_key ?? '',
                'type_id' => $user->type_id,
                'allowed_devices_count' => $user->allowedActiveDevicesCount,
            ]);
        }
        return $this->error($model->firstErrorMessage);

    }

    public function actionLoginStudent(): array
    {
        $model = new LoginFormStudent();
        if ($model->load($this->post(), '') && $model->validate()) {
            $user = $model->user;
            if (!$user->auth_key) {
                $user->auth_key = Yii::$app->security->generateRandomString();
                $user->save();
            }
            return $this->success([
                'id' => $user->id,
                'username' => Html::encode($user->username),
                'full_name' => Html::encode($user->full_name),
                'born_date' => Yii::$app->formatter->asDate($user->born_date, 'php:d.m.Y'),
                'regionName' => $user->region->name_uz ?? '',
                'region_id' => $user->region_id,
                'districtName' => $user->district->name_uz ?? '',
                'district_id' => $user->district_id,
                'sexName' => $user->sexTypeName(),
                'imageUrl' => $user->getImageUrl(),
                'status' => $user->status,
                'statusName' => $user->statusName,
                'auth_key' => $user->auth_key ?? '',
                'type_id' => $user->type_id,
                'allowed_devices_count' => $user->allowedActiveDevicesCount,
            ]);
        }
        return $this->error($model->firstErrorMessage);

    }
}
