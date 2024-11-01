<?php

namespace api\modules\testmanager\models;

use soft\db\ActiveQuery;
use Yii;

class TestResult extends \common\modules\testmanager\models\TestResult
{
    public function fields()
    {
        $key = self::generateFieldParam();
        if (isset(self::$fields[$key])) {
            return self::$fields[$key];
        }
        return [
            'id',
            'tests_count',
            'test_id',
            'testName' => function (TestResult $model) {
                return $model->test->name;
            },
            'status',
            'statusName' => function (TestResult $model) {
                return $model->statusName();
            },
            'started_at',
            'startedTime' => function (TestResult $model) {
                return \Yii::$app->formatter->asDatetime($model->started_at, 'php:d-m-Y H:i:s');
            },
            'finished_at',
            'finishedTime' => function (TestResult $model) {
                return $model->finished_at ? \Yii::$app->formatter->asDatetime($model->finished_at, 'php:d-m-Y H:i:s') : '';
            },
            'correct_answers',
            'expire_at',
            'expireTime' => function (TestResult $model) {
                return \Yii::$app->formatter->asDatetime($model->expire_at, 'php:m-d-Y H:i:s');
            },
            'price',
            'score',
            'results' => function (TestResult $model) {
                return $model->testResultItems;
            },
            'subjectName' => function (TestResult $model) {
                return $model->test->subject->name;
            },
            'courseName' => function (TestResult $model) {
                return $model->test->course->name ?? '';
            },
            'directionName' => function (TestResult $model) {
                return $model->test->direction->name ?? '';
            },
        ];
    }


    public function getTestResultItems(): ActiveQuery
    {
        return $this->hasMany(TestResultItem::className(), ['test_result_id' => 'id'])->with(['question', 'testResult']);
    }
}