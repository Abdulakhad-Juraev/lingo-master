<?php

namespace api\modules\testmanager\controllers;

use api\controllers\ApiBaseController;
use api\models\Subject;
use api\modules\testmanager\models\Question;
use api\modules\testmanager\models\Test;
use api\modules\testmanager\models\TestResult;
use common\models\User;
use common\modules\testmanager\models\Option;
use common\modules\testmanager\models\search\TestSearch;
use common\modules\testmanager\models\TestResultItem;
use common\modules\testmanager\models\UserOptions;
use common\modules\testmanager\models\UserQuestion;
use common\modules\usermanager\models\Balance;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\ServerErrorHttpException;

class TestController extends ApiBaseController
{
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
    public $authRequired = true;

    public function actionIndex(): array
    {
        $user = \Yii::$app->user->identity;
        $searchModel = new TestSearch();
        $testsQuery = Test::find()
            ->andWhere(['status' => Test::STATUS_ACTIVE])
            ->andWhere([
                'or',
                [
                    'and',
                    ['<=', 'started_at', strtotime('+7 day')],
                    ['>', 'finished_at', time()],
                ],
                [
                    'and',
                    ['finished_at' => null],
                    ['<=', 'started_at', strtotime('+7 day')],
                ],
            ]);
        if (isset($user->type_id) && $user->type_id == User::TYPE_ID_STUDENT) {
            $testsQuery->andWhere([
                'or',
                ['test_type' => Test::TEST_TYPE_OPEN],
                [
                    'and',
                    ['direction_id' => $user->direction_id],
                    ['language_id' => $user->language_id],
                    ['course_id' => $user->course_id],
                ],
            ]);
        } else {
            $testsQuery->andWhere(['test_type' => Test::TEST_TYPE_OPEN]);
        }
        $tests = $searchModel->search($testsQuery, Yii::$app->request->queryParams, 6);
        return $this->success([
            'tests' => $tests
        ]);
    }

    /**
     * @throws InvalidConfigException
     * @throws ServerErrorHttpException
     */
    public function actionStarted(int $id): array
    {
        $user = \Yii::$app->user->identity;

        // Check for existing active test result
        /** @var TestResult $result */
        $currentTime = time();

        $result = TestResult::find()
            ->with(['test', 'test.subject'])
            ->where(['user_id' => $user->id, 'status' => TestResult::STATUS_ACTIVE])
            ->one();
        if ($result) {
            if ($result->test_id != $id) {
                return $this->error('Test topilmadi', 403, ['started_id' => $result->test_id]);
            }
            if ($result->expire_at < $currentTime) {
                Yii::$app->response->statusCode = 420;
                return $this->error(t('You have an incomplete test'), 420,['started_id' => $result->test_id]);
            }
            if ($result->test_id == $id) {
                return $this->fetchTestResultData($result);
            }
        }
// Handle case when no active test result is found or other appropriate logic
        // Prepare query to find the test
        $query = Test::find()
            ->where(['id' => $id, 'status' => Test::STATUS_ACTIVE])
            ->andWhere([
                'or',
                [
                    'and',
                    ['<=', 'started_at', strtotime('+7 day')],
                    ['>', 'finished_at', time()],
                ],
                [
                    'and',
                    ['finished_at' => null],
                    ['<=', 'started_at', strtotime('+7 day')],
                ],
            ]);
        if ($user->type_id == User::TYPE_ID_STUDENT) {
            $query->andWhere([
                'or',
                ['test_type' => Test::TEST_TYPE_OPEN],
                [
                    'direction_id' => $user->direction_id,
                    'language_id' => $user->language_id,
                    'course_id' => $user->course_id,
                ],
            ]);
        } else {
            $query->andWhere(['test_type' => Test::TEST_TYPE_OPEN]);
        }

        /** @var \common\modules\testmanager\models\Test $test */
        $test = $query->one();
        if (!$test) {
            return $this->error(t('You do not have access to this test'));
        }
        $count_test_user = TestResult::find()
            ->andWhere(['user_id' => Yii::$app->user->identity->id])
            ->andWhere(['test_id' => $test->id])
            ->count();
        if ($test->is_free && $test->number_tries <= $count_test_user) {
            return $this->error(t('You have no attempts left'));
        }
        if (!$test->is_free && !isset($test->testEnroll)) {
            return $this->error(t('You have no attempts left'));
        }

        // Prepare questions for the test
        $prepareQuestions = $test->prepareQuestions();

        if (empty($prepareQuestions)) {
            return $this->error(t('There is currently no active test'));
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $result = new TestResult([
                'user_id' => $user->id,
                'tests_count' => $test->tests_count,
                'test_id' => $test->id,
                'started_at' => $currentTime,
                'duration' => $test->duration,
                'expire_at' => strtotime('+' . $test->duration . ' minute'),
                'price' => $test->price,
            ]);

            if (!$result->save()) {
                throw new \Exception(t('Error saving results'));
            }


            $resultItems = [];
            $optionItems = [];

            foreach ($prepareQuestions as $index => $prepareQuestion) {
                $resultItems[] = [
                    'test_result_id' => $result->id,
                    'question_id' => $prepareQuestion->id,
                    'original_answer_id' => $prepareQuestion->correctAnswer,
                ];
                foreach ($prepareQuestion->randomOptions as $option) {
                    $optionItems[] = [
                        'question_id' => $prepareQuestion->id,
                        'result_id' => $result->id,
                        'option_id' => $option->id,
                    ];
                }
            }
            Yii::$app->db->createCommand()
                ->batchInsert(TestResultItem::tableName(), ['test_result_id', 'question_id', 'original_answer_id'], $resultItems)
                ->execute();
            Yii::$app->db->createCommand()
                ->batchInsert(UserOptions::tableName(), ['question_id', 'result_id', 'option_id'], $optionItems)
                ->execute();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->error($e->getMessage());
        }

        return $this->fetchTestResultData($result);
    }

    private function fetchTestResultData($result): array
    {
        /** @var TestResult $result */
        return $this->success([
            'test' => [
                'id' => $result->id,
                'tests_count' => $result->tests_count,
                'test_id' => $result->test_id,
                'subject_id' => $result->test->subject_id,
                'subjectName' => $result->test->subject['name_' . Yii::$app->language],
                'testName' => $result->test->name,
                'testDuration' => $result->test->duration,
                'started_at' => $result->started_at,
                'startedTime' => \Yii::$app->formatter->asDatetime($result->started_at, 'php:d-m-Y H:i:s'),
                'expire_at' => $result->expire_at,
                'expireTime' => \Yii::$app->formatter->asDatetime($result->expire_at, 'php:m-d-Y H:i:s'),
                'price' => $result->price,
            ],
            'question' => $result->questions,
        ]);
    }

    public function actionFinished($id): array
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $answer_array = json_decode(Yii::$app->request->rawBody, true);

        // Testni olish
        TestResult::setFields([
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
            'score',
        ]);

        $result = TestResult::find()
            ->with('test')
            ->andWhere(['test_id' => $id])
            ->andWhere(['user_id' => $user->id])
            ->andWhere(['status' => TestResult::STATUS_ACTIVE])
            ->one();

        if (!$result) {
            return $this->error(t('No result'));
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!empty($answer_array)) {
                $questionIds = array_column($answer_array, 'question_id');
                $resultItems = TestResultItem::find()
                    ->andWhere(['test_result_id' => $result->id])
                    ->andWhere(['question_id' => $questionIds])
                    ->indexBy('question_id')
                    ->all();

                $result_item_array = [];
                foreach ($answer_array as $item) {
                    $questionId = $item['question_id'];
                    $result_item = $resultItems[$questionId] ?? null;

                    if (!$result_item) {
                        throw new \Exception(t('Test result item not found'));
                    }

                    $is_correct = ($item['option_id'] === $result_item->original_answer_id) ? TestResultItem::IS_CORRECT_TRUE : TestResultItem::IS_CORRECT_FALSE;

                    // Update result item fields
                    $result_item->user_answer_id = $item['option_id'];
                    $result_item->is_correct = $is_correct;
                    $result_item->is_checked = true;

                    // Add result item to array for batch update
                    $result_item_array[] = $result_item;
                }

                // Prepare batch update SQL
                $cases_user_answer = '';
                $cases_is_correct = '';
                $ids = [];
                foreach ($result_item_array as $result_item) {
                    $id = $result_item->id;
                    $user_answer_id = $result_item->user_answer_id;
                    $is_correct = $result_item->is_correct ? 1 : 0; // Format correctly for SQL
                    $cases_user_answer .= "WHEN {$id} THEN {$user_answer_id} ";
                    $cases_is_correct .= "WHEN {$id} THEN {$is_correct} ";
                    $ids[] = $id;
                }
                $ids_str = implode(',', $ids);

                // Execute batch update SQL
                $sql = "UPDATE " . TestResultItem::tableName() . " SET 
                user_answer_id = CASE id {$cases_user_answer} END,
                is_correct = CASE id {$cases_is_correct} END
                WHERE id IN ({$ids_str})";
                Yii::$app->db->createCommand($sql)->execute();


            }
            // Update test result
            $result->status = TestResult::STATUS_FINISHED;
            $result->finished_at = time();
            $result->correct_answers = $result->correctAnswerCount();
            $result->score = $result->correct_answers * (int)($result->test->maximum_score / $result->tests_count);

            if (!$result->save()) {
                throw new \Exception(t('Error saving results'));
            }
            $transaction->commit();
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return $this->error($exception->getMessage());
        }

        return $this->success($result);
    }


}