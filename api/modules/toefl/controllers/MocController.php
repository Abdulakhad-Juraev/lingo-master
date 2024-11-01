<?php

namespace api\modules\toefl\controllers;

use api\controllers\ApiBaseController;
use api\modules\toefl\models\EnglishExam;
use api\modules\toefl\models\ToeflResult;
use common\modules\toeflExam\models\BadScoreToefl;
use common\modules\toeflExam\models\search\EnglishExamSearch;
use common\modules\toeflExam\models\ToeflQuestion;
use common\modules\toeflExam\models\ToeflResultItem;
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
            ->andWhere(['type' => EnglishExam::TYPE_TOEFL]);
        $searchModel = new EnglishExamSearch();
        $dataProvider = $searchModel->search($query);
        return $this->success($dataProvider);
    }

    public function actionFinished(int $exam_id)
    {
        $userId = Yii::$app->user->id;
        ToeflResult::setFields([

            'id',
            'correct_answers_listening',
            'correct_answers_reading',
            'correct_answers_writing',
            'cefr_level',
            'started_at',
            'finished_at'
        ]);
        // Fetch the TOEFL result for the current user and exam
        $result = ToeflResult::find()
            ->andWhere(['exam_id' => $exam_id, 'user_id' => $userId, 'status' => ToeflResult::STATUS_ACTIVE])
            ->one();

        if (!$result) {
            return $this->error('No active result found for the exam');
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            /** @var ToeflResult $result */
            $questionTypes = [
                'listening' => ToeflQuestion::TYPE_LISTENING,
                'writing' => ToeflQuestion::TYPE_WRITING,
                'reading' => ToeflQuestion::TYPE_READING
            ];

            // Query to get correct answers count for all types in one go
            $correctAnswers = ToeflResultItem::find()
                ->alias('tri')
                ->innerJoin('toefl_question tq', 'tq.id = tri.question_id')
                ->where(['tri.result_id' => $result->id, 'tri.is_correct' => 1])
                ->andWhere(['in', 'tq.type_id', $questionTypes])
                ->select(['tq.type_id', 'COUNT(*) AS correct_count'])
                ->groupBy('tq.type_id')
                ->indexBy('tq.type_id')
                ->asArray()
                ->all();

            if ($result->correct_answers_listening === 0){
                $result->correct_answers_listening = \common\modules\toeflExam\models\ToeflResultItem::find()
                    ->andWhere(['type_id' => ToeflQuestion::TYPE_LISTENING])
                    ->andWhere(['is_correct' => 1])
                    ->andWhere(['result_id' => $result->id])
                    ->count();
            }
            if ($result->correct_answers_writing === 0) {
                $result->correct_answers_writing = \common\modules\toeflExam\models\ToeflResultItem::find()
                    ->andWhere(['type_id' => ToeflQuestion::TYPE_WRITING])
                    ->andWhere(['is_correct' => 1])
                    ->andWhere(['result_id' => $result->id])
                    ->count();
            }
            if ($result->correct_answers_reading === 0) {
                $result->correct_answers_reading = \common\modules\toeflExam\models\ToeflResultItem::find()
                    ->andWhere(['type_id' => ToeflQuestion::TYPE_READING])
                    ->andWhere(['is_correct' => 1])
                    ->andWhere(['result_id' => $result->id])
                    ->count();
            }

            // Calculate raw scores for each section
            $rawScores = [
                'listening' => $result->correct_answers_listening,
                'writing' => $result->correct_answers_writing,
                'reading' => $result->correct_answers_reading,
            ];

            // Instantiate BadScoreToefl model and calculate scaled scores
            $badModel = new BadScoreToefl();
            $scores = $badModel->testScaledScores($rawScores);

            // Set finished times based on step
            $currentStep = $result->step;
            $timeNow = time();
            $result->finished_at = $timeNow; // Assuming this is the overall finish time
            $result->status = ToeflResult::STATUS_INACTIVE;

            if ($currentStep === ToeflResult::STEP_LISTENING) {
                $result->finished_at_listening = $timeNow;
                $result->finished_at_writing = $timeNow;
                $result->finished_at_reading = $timeNow;
            } elseif ($currentStep === ToeflResult::STEP_WRITING) {
                $result->finished_at_writing = $timeNow;
                $result->finished_at_reading = $timeNow;
            } elseif ($currentStep === ToeflResult::STEP_READING) {
                $result->finished_at_reading = $timeNow;
            }

            // Set scores
            $result->listening_score = $scores[0];
            $result->writing_score = $scores[1];
            $result->reading_score = $scores[2];
            $result->calculateTotalScore();
            // Update step to finished
            $result->step = ToeflResult::STEP_FINISHED;
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