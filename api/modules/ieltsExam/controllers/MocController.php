<?php

namespace api\modules\ieltsExam\controllers;

use api\controllers\ApiBaseController;
use api\modules\ieltsExam\models\EnglishExam;
use api\modules\ieltsExam\models\IeltsQuestions;
use api\modules\ieltsExam\models\IeltsResult;
use api\modules\ieltsExam\models\IeltsResultItem;
use common\modules\ieltsExam\models\BandScoreIelts;
use common\modules\toeflExam\models\search\EnglishExamSearch;
use Yii;

class MocController extends ApiBaseController
{
    public $authRequired = true;
    public $authOptional = ['index'];
    public $authOnly = ['index', 'finished'];

    public function actionIndex()
    {
        $query = EnglishExam::find()
            ->andWhere(['status' => EnglishExam::STATUS_ACTIVE])
            ->andWhere(['type' => EnglishExam::TYPE_IELTS]);
        $searchModel = new EnglishExamSearch();
        $dataProvider = $searchModel->search($query);
        return $this->success($dataProvider);
    }

    public function actionFinished(int $exam_id)
    {
        $userId = Yii::$app->user->id;

        IeltsResult::setFields([
            'id',
            'correct_answers_listening',
            'correct_answers_reading',
            'started_at',
            'finished_at'
        ]);

        // Fetch the IELTS result for the current user and exam
        $result = IeltsResult::find()
            ->andWhere(['exam_id' => $exam_id, 'user_id' => $userId, 'status' => IeltsResult::STATUS_ACTIVE])
            ->one();

        if (!$result) {
            return $this->error('No active result found for the exam');
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            /** @var IeltsResult $result */
            $questionTypes = [
                'listening' => IeltsQuestions::TYPE_LISTENING_GROUP,
                'reading' => IeltsQuestions::TYPE_READING_GROUP
            ];
            if ($result->correct_answers_listening === 0) {
                // Set correct answers for each section
                $result->correct_answers_listening = \common\modules\ieltsExam\models\IeltsResultItem::find()
                    ->andWhere(['type_id' => IeltsResultItem::TYPE_LISTENING])
                    ->andWhere(['is_correct' => 1])
                    ->andWhere(['result_id' => $result->id])
                    ->count();
            }
            if ($result->correct_answers_reading === 0) {
                $result->correct_answers_reading = \common\modules\ieltsExam\models\IeltsResultItem::find()
                    ->andWhere(['type_id' => IeltsResultItem::TYPE_READING])
                    ->andWhere(['is_correct' => 1])
                    ->andWhere(['result_id' => $result->id])
                    ->count();
            }
            // Calculate raw scores for each section
            $rawScores = [
                'listening' => $result->correct_answers_listening,
                'reading' => $result->correct_answers_reading,
            ];

            // Instantiate BandScoreIelts model and calculate band scores
            $bandModel = new BandScoreIelts();
            $bandScores = $bandModel->testBandScores($rawScores);

            // Set finished times based on step
            $currentStep = $result->step;
            $timeNow = time();
            $result->finished_at = $timeNow; // Assuming this is the overall finish time
            $result->status = IeltsResult::STATUS_INACTIVE;

            if ($currentStep === IeltsResult::STEP_LISTENING) {
                $result->finished_at_listening = $timeNow;
                $result->finished_at_writing = $timeNow;
                $result->finished_at_reading = $timeNow;
                $result->finished_at_speaking = $timeNow;
            } elseif ($currentStep === IeltsResult::STEP_READING) {
                $result->finished_at_writing = $timeNow;
                $result->finished_at_reading = $timeNow;
                $result->finished_at_speaking = $timeNow;
            } elseif ($currentStep === IeltsResult::STEP_WRITING) {
                $result->finished_at_writing = $timeNow;
                $result->finished_at_speaking = $timeNow;
            } elseif ($currentStep === IeltsResult::STEP_SPEAKING) {
                $result->finished_at_speaking = $timeNow;
            }
            // Set scores
            $result->listening_score = $bandScores['listening'] ?? 0;
            $result->reading_score = $bandScores['reading'] ?? 0;

            // Update step to finished
            $result->step = IeltsResult::STEP_FINISHED;

            // Save result
            if (!$result->save()) {
                throw new \Exception('Failed to save result');
            }

            $transaction->commit();
            return $this->success($result);

        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->error('Failed to save answers: ' . $e->getMessage());
        }
    }
}
