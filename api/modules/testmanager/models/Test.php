<?php

namespace api\modules\testmanager\models;

use common\modules\testmanager\models\TestEnroll;
use Yii;

class Test extends \common\modules\testmanager\models\Test
{
    public function fields()
    {
        $currentUserId = Yii::$app->user->id;

        $test = TestResult::find()
            ->andWhere(['status' => TestResult::STATUS_ACTIVE])
            ->andWhere(['user_id' => $currentUserId]) // Properly fetch current user ID
            ->one();
        return [
            'id',
            'name',
            'is_free',
            'price',
            'started_at' => function (Test $model) {
                return Yii::$app->formatter->asDatetime($model->started_at, 'php:d-m-Y H:i:s');
            },
            'finished_at' => function (Test $model) {
                return Yii::$app->formatter->asDatetime($model->finished_at, 'php:d-m-Y H:i:s');
            },
            'duration',
            'tests_count',
            'test_type',
            'testTypeName' => function (Test $model) {
                return $model->testTypeName;
            },
            'subject_id',
            'subjectName' => function (Test $model) {
                return $model->subject->name ?? '';
            },
            'show_answer',
            'controlTypeName' => function (Test $model) {
                return $model->controlTypeName ?? '';
            },
            'number_tries',
            'used_attempts' => function (Test $model) use ($currentUserId) {
                return (int)TestResult::find()
                    ->andWhere(['status' => TestResult::STATUS_FINISHED])
                    ->andWhere(['test_id' => $model->id])
                    ->andWhere(['user_id' => $currentUserId])
                    ->count();
            },
            'current_time' => function (Test $model) {
                return time();
            },
            'startedAT' => function (Test $model) {
                return $model->started_at;
            },
            'is_active' => function (Test $model) {
                $currentTime = time();
                $startedAt = $model->started_at;
                $finishedAt = $model->finished_at ? $model->finished_at : null;
                return $startedAt <= $currentTime && (!$finishedAt || $finishedAt >= $currentTime);
            },
            'is_payment' => function (Test $model) {
                return (bool)$model->testEnroll;
            },
            'active_user_test' => function (Test $model) use ($test) {
                return $test && $test->test_id === $model->id;
            },
        ];
    }
}

