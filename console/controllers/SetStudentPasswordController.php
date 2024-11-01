<?php

namespace console\controllers;

use api\modules\auth\models\Student;
use common\models\User;
use Yii;

class SetStudentPasswordController extends \yii\console\Controller
{
    public function actionIndex(): void
    {
        $users = User::find()
            ->andWhere(['!=', 'simple_password', 0])
            ->andWhere(['type_id' => User::TYPE_ID_STUDENT])
            ->andWhere(['status'=>User::STATUS_ACTIVE])
            ->limit(70)
            ->all();
        if (!empty($users)) {
            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {
                $updateRows = [];
                foreach ($users as $user) {
                    /** @var User $user */
                    $passwordHash = Yii::$app->security->generatePasswordHash($user->simple_password);
                    $updateRows[] = [
                        'id' => $user->id,
                        'password_hash' => $passwordHash,
                        'simple_password' => 0,
                    ];
                }
                // Prepare the batch update
                foreach ($updateRows as $row) {
                    $db->createCommand()
                        ->update(
                            User::tableName(),
                            [
                                'password_hash' => $row['password_hash'],
                                'simple_password' => $row['simple_password'],
                            ],
                            ['id' => $row['id']]
                        )
                        ->execute();
                }

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::error($e->getMessage(), __METHOD__);
                throw $e;
            }
        }
    }

}