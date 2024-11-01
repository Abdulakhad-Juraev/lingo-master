<?php

namespace api\modules\auth\controllers;

use api\controllers\ApiBaseController;
use api\models\User;
use api\modules\auth\models\RegisterForm;
use common\modules\usermanager\models\UserDevice;
use soft\helpers\Html;
use Yii;
use yii\base\Exception;

class RegisterController extends ApiBaseController
{

//    public $authRequired = true;
//    public $authOnly = ['student'];
//    public $authOptional = ['student', 'phone', 'verify', 'sign-up'];


    /**
     * @return array
     * @throws Exception
     */
    public function actionPhone(): array
    {
        $model = new RegisterForm([
            'scenario' => 'phone',
        ]);

        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            if ($model->saveTempUser()) {
                return $this->success();
            }
        }
        return $this->error($model->firstErrorMessage);

    }

    /**
     * @return array
     */
    public function actionVerify(): array
    {
        $model = new RegisterForm([
            'scenario' => RegisterForm::SCENARIO_VERIFY,
        ]);

        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {

            return $this->success();
        }
        return $this->error($model->firstErrorMessage);
    }

    /**
     * @return array
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function actionSignUp(): array
    {
        $model = new RegisterForm([
            'scenario' => RegisterForm::SCENARIO_REGISTER,
        ]);
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
//        dd($model);

            $result = $model->register();

            if ($result != false) {

                /** @var User $user */
                $user = $result['user'];
//                /** @var UserDevice $device */
//                $device = $result['device'];
                $data = [
                    'id' => $user->id,
                    'username' => Html::encode($user->username),
                    'full_name' => Html::encode($user->firstname . " " . $user->lastname),
                    'status' => $user->status,
                    'auth_key' => $user->auth_key ?? '',
                    'type_id' => $user->type_id,
//                    'born_date' => Yii::$app->formatter->asDate($user->born_date, 'php:d.m.Y'),
//                    'regionName' => $user->region->name_uz ?? '',
//                    'region_id' => $user->region_id,
//                    'districtName' => $user->district->name_uz ?? '',
//                    'district_id' => $user->district_id,
//                    'sexName' => $user->sexTypeName(),
//                    'imageUrl' => $user->getImageUrl(),
//                    'statusName' => $user->statusName,
//                    'allowed_devices_count' => $user->allowedActiveDevicesCount,
                ];

                return $this->success($data);
            }

        }
        return $this->error($model->firstErrorMessage);
    }

//    public function actionStudent(): array
//    {
//        $user_id = Yii::$app->user->identity->id;
//        $user = User::findOne($user_id);
//        if (!$user) {
//            return $this->error(['User not found.']);
//        }
//        $model = new Student();
//        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
//            // Set only the attributes that are safe to assign
//            $user->faculty_id = $model->faculty_id;
//            $user->direction_id = $model->direction_id;
//            $user->course_id = $model->course_id;
//            $user->language_id = $model->language_id;
//            $user->type_id = User::TYPE_ID_STUDENT;
//            if ($user->save()) {
//                return $this->success();
//            } else {
//                return $this->error($user->errors);
//            }
//        }
//        return $this->error($model->errors);
//    }
}
