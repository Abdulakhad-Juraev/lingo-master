<?php

namespace api\modules\profile\controllers;

use api\controllers\ApiBaseController;
use api\modules\testmanager\models\TestResult;
use common\modules\testmanager\models\search\TestResultSearch;

class ResultController extends ApiBaseController
{
    public $authRequired = true;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function actionIndex()
    {
        $user_id = \Yii::$app->user->identity->getId();
        $searchModel = new TestResultSearch();

        // TestResult modelidagi kerakli maydonlarni sozlash
        TestResult::setFields([
            'id',
            'tests_count',
            'testName' => function (TestResult $model) {
                return $model->test->name;
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
            'correct_answers',
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
                return \Yii::$app->formatter->asDatetime($model->finished_at, 'php:d-m-Y H:i:s');
            },
            'expire_at',
            'price',
        ]);

        // Foydalanuvchi test natijalarini so'rovini yaratish
        $query = TestResult::find()
            ->with('test')
            ->where(['user_id' => $user_id])
            ->andWhere(['is not', 'test_result.finished_at', null])
            ->orderBy(['test_result.started_at' => SORT_DESC]);

        // DataProvider yaratish
        $dataProvider = $searchModel->search($query);

        return $this->success($dataProvider);
    }

    public function actionTestDetail($id): array
    {
        $model = TestResult::find()->andWhere(['id' => $id])->one();
        if (!$model) {
            return $this->error(t('Result not found'));
        }
        return $this->success([
            $model,

        ]);
    }
}