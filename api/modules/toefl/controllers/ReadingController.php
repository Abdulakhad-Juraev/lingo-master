<?php

namespace api\modules\toefl\controllers;

use api\controllers\ApiBaseController;
use api\modules\toefl\models\ToeflResult;
use common\modules\toeflExam\models\BadScoreToefl;
use common\modules\toeflExam\models\EnglishExam;
use common\modules\toeflExam\models\ToeflQuestion;
use common\modules\toeflExam\models\ToeflResultItem;
use common\modules\toeflExam\models\ToeflResultQuestion;
use Yii;

class ReadingController extends ApiBaseController
{

    public $authRequired = true;

    public function actionStart(int $exam_id)
    {
        /** @var EnglishExam $exam */
        $exam = EnglishExam::findOne($exam_id);
        if (!$exam) {
            return $this->error('Invalid exam ID');
        }
        /** @var ToeflResult $result */
        $result = user()->activeToeflTest;
        if (!$result) {
            return $this->error('Result topilmadi');
        }
// Check stage and expiration
        $currentTime = time();
        if ($result) {
            if ($result->step !== ToeflResult::STEP_READING) {
                Yii::$app->response->statusCode = 421;
                return $this->error('You are not at this stage', 421);
            }
            if ($result->expire_at < time() || $result->exam_id !== $exam_id) {
                Yii::$app->response->statusCode = 420;
                return $this->error('You have an incomplete test', 420);
            }
            if (isset($result->expire_at_reading) && $result->expire_at_reading < $currentTime) {
                Yii::$app->response->statusCode = 419;
                return $this->error('You have an incomplete test', 419);
            }
        }
        if (isset($result->started_at_reading)) {
            return $this->fetchTestResultData($result);
        }
        $prepareQuestions = $exam->prepareQuestionReadingToefl();
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $resultItems = [];
            $resultQuestionGroup = [];
            foreach ($prepareQuestions as $prepareQuestion) {
                $resultQuestionGroup[] = [
                    'r_group_id' => $prepareQuestion->id,
                    'result_id' => $result->id,
                    'user_id' => Yii::$app->user->identity->getId(),
                    'is_used' => ToeflResultQuestion::IS_USED_FALSE,
                ];
                foreach ($prepareQuestion->toeflQuestions as $toeflQuestion) {
                    $resultItems[] = [
                        'result_id' => $result->id,
                        'question_id' => $toeflQuestion->id,
                        'original_answer_id' => $toeflQuestion->correctAnswer,
                        'reading_group_id' => $prepareQuestion->id,
                        'type_id' => ToeflResultItem::TYPE_READING
                    ];
                }
            }
            $result->started_at_reading = time();
            $result->expire_at_reading = strtotime('+' . $exam->reading_duration . ' minute');
            $result->save();
            Yii::$app->db->createCommand()
                ->batchInsert(ToeflResultQuestion::tableName(), ['r_group_id', 'result_id', 'user_id', 'is_used'], $resultQuestionGroup)
                ->execute();
            Yii::$app->db->createCommand()
                ->batchInsert(ToeflResultItem::tableName(), ['result_id', 'question_id', 'original_answer_id', 'reading_group_id', 'type_id'], $resultItems)
                ->execute();
            $transaction->commit();
            return $this->fetchTestResultData($result);
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->error($e->getMessage());
        }
    }

    public function actionNext()
    {
        $json = json_decode(Yii::$app->request->rawBody, true);
        if ($json === null) {
            return $this->error('Invalid JSON data received');
        }
        $userId = Yii::$app->user->id;
        $user = Yii::$app->user->identity;
        $examId = $json['exam_id'] ?? null;
        $readingGroupId = $json['reading_group_id'] ?? null;
        $answers = $json['answers'] ?? [];
        $result = $user->activeToeflTest;
        if (!$result || $result->exam_id !== $examId) {
            return $this->error('No active result found for the exam');
        }
        if (empty($answers)) {
            return $this->error('Savollarga javob berilmadi');
        }
        $resultQuestionGroup = $this->getToeflResultQuestionGroup($readingGroupId, $userId, $result->id);
        if (!$resultQuestionGroup) {
            return $this->error('Question group not found or already used');
        }
        $resultItems = $this->getResultItems($result->id, $readingGroupId);
        if (empty($resultItems)) {
            return $this->error('Savollar topilamdi');
        }
        $updateData = $this->prepareUpdateData($answers, $resultItems);
        if (empty($updateData)) {
            return $this->error('No valid answers to save');
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->updateResultItems($updateData);
            $this->markQuestionGroupAsUsed($resultQuestionGroup);
            /** @var ToeflResult $result */
            if (!empty($result->questionsReading) && (strtotime(Yii::$app->formatter->asDatetime($result->expire_at_reading, 'php:d.m.Y H:i')))) {
                $transaction->commit();
                return $this->fetchTestResultData($result);
            }
            $transaction->commit();
            return $this->success();
        } catch
        (\Exception $e) {
            $transaction->rollBack();
            return $this->error($e->getMessage());
        }
    }

    private function getActiveToeflResult($examId, $userId)
    {
        return ToeflResult::find()
            ->andWhere(['exam_id' => $examId])
            ->andWhere(['user_id' => $userId])
            ->andWhere(['status' => ToeflResult::STATUS_ACTIVE])
            ->one();
    }

    private function getToeflResultQuestionGroup($readingGroupId, $userId, $result_id)
    {
        return ToeflResultQuestion::find()
            ->andWhere(['r_group_id' => $readingGroupId])
            ->andWhere(['user_id' => $userId])
            ->andWhere(['result_id' => $result_id])
            ->andWhere(['is_used' => ToeflResultQuestion::IS_USED_FALSE])
            ->one();
    }

    private function getResultItems($resultId, $readingGroupId)
    {
        return ToeflResultItem::find()
            ->andWhere(['result_id' => $resultId, 'reading_group_id' => $readingGroupId])
            ->indexBy('question_id')
            ->all();
    }

    private function completeListeningStep($result)
    {
        /** @var ToeflResult $result */
        $result->correct_answers_reading = ToeflResultItem::find()
            ->leftJoin('toefl_question', 'toefl_question.id = toefl_result_item.question_id')
            ->andWhere(['toefl_question.type_id' => ToeflQuestion::TYPE_READING])
            ->andWhere(['result_id' => $result->id])
            ->andWhere(['is_correct' => 1])
            ->count();
        // Calculate raw scores for each section
        /** @var ToeflResult $result */
        $rawScores = [
            'listening' => $result->correct_answers_listening,
            'writing' => $result->correct_answers_writing,
            'reading' => $result->correct_answers_reading,
        ];
        // Instantiate BadScoreToefl model and calculate scaled scores
        $badModel = new BadScoreToefl();
        $scores = $badModel->testScaledScores($rawScores);
        $result->listening_score = $scores[0];
        $result->writing_score = $scores[1];
        $result->reading_score = $scores[2];
        $result->finished_at_listening = time();
        $result->finished_at = time();
        $result->status = ToeflResult::STATUS_INACTIVE;
        $result->calculateTotalScore();
        $result->step = ToeflResult::STEP_FINISHED;
        return $result->save();
    }


    private function prepareUpdateData($answers, $resultItems)
    {
        $updateData = [
            'cases_user_answer' => '',
            'cases_is_correct' => '',
            'ids' => []
        ];

        foreach ($answers as $answerData) {
            $questionId = $answerData['question_id'];
            $optionId = $answerData['option_id'] ?? null;
            $resultItem = $resultItems[$questionId] ?? null;

            if (!$resultItem) {
                return [];
            }

            $isCorrect = ($optionId === $resultItem->original_answer_id) ? 1 : 0;
            $id = $resultItem->id;
            // If optionId is null, set userAnswerId to 'NULL' for SQL
            $userAnswerId = $optionId !== null ? $optionId : 'NULL';

            $updateData['cases_user_answer'] .= "WHEN {$id} THEN {$userAnswerId} ";
            $updateData['cases_is_correct'] .= "WHEN {$id} THEN {$isCorrect} ";
            $updateData['ids'][] = $id;
        }

        return $updateData;
    }


    private function updateResultItems($updateData)
    {
        $idsStr = implode(',', $updateData['ids']);
        $sql = "UPDATE " . ToeflResultItem::tableName() . " SET 
            user_answer_id = CASE id {$updateData['cases_user_answer']} END,
            is_correct = CASE id {$updateData['cases_is_correct']} END
            WHERE id IN ({$idsStr})";
        Yii::$app->db->createCommand($sql)->execute();
    }

    private function markQuestionGroupAsUsed($resultQuestionGroup)
    {
        $resultQuestionGroup->is_used = ToeflResultQuestion::IS_USED_TRUE;
        $resultQuestionGroup->save();
    }

    public function actionFinished()
    {
        ToeflResult::setFields([
            'id',
            'correct_answers_listening',
            'correct_answers_reading',
            'correct_answers_writing',
            'cefr_level',
            'started_at',
            'finished_at'
        ]);
        $json = json_decode(Yii::$app->request->rawBody, true);

        // Validate the decoded JSON
        if ($json === null) {
            return $this->error('Invalid JSON data received');
        }

        $userId = Yii::$app->user->id;
        $examId = $json['exam_id'] ?? null;
        $readingGroupId = $json['reading_group_id'] ?? null;
        $answers = $json['answers'] ?? [];

        // Fetch the TOEFL result for the current user and exam
        $result = $this->getActiveToeflResult($examId, $userId);

        if (!$result) {
            return $this->error('No active result found for the exam');
        }

        $resultItems = $this->getResultItems($result->id, $readingGroupId);
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (!empty($answers)) {
                // Fetch the TOEFL result question group
                $resultQuestionGroup = $this->getToeflResultQuestionGroup($readingGroupId, $userId, $result->id);
                if (!$resultQuestionGroup) {
                    throw new \Exception('Question group not found or already used');
                }

                $updateData = $this->prepareUpdateData($answers, $resultItems);

                if (empty($updateData)) {
                    return $this->error('No valid answers to save');
                }

                $this->updateResultItems($updateData);
                $this->markQuestionGroupAsUsed($resultQuestionGroup);
            }
            // Mark all relevant TOEFL result questions as used
            $updateCount = ToeflResultQuestion::updateAll(
                ['is_used' => ToeflResultQuestion::IS_USED_TRUE],
                ['user_id' => $userId, 'is_used' => ToeflResultQuestion::IS_USED_FALSE, ['not', ['r_group_id' => null]]]
            );
            if ($updateCount === 0) {
                throw new \Exception('Failed to mark all question groups as used');
            }
            $this->completeListeningStep($result);
            $transaction->commit();
            return $this->success($result);
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->error('Failed to save answers: ' . $e->getMessage());
        }
    }

    private function fetchTestResultData($result): array
    {
        /** @var ToeflResult $result */
        return $this->success([
            'test' => [
                'id' => $result->id,
                'exam_id' => $result->exam_id,
                'title' => $result->exam->title,
                'started_at_reading' => $result->started_at_reading,
                'startedTime' => \Yii::$app->formatter->asDatetime($result->started_at_reading, 'php:d-m-Y H:i:s'),
                'expire_at_reading' => $result->expire_at_reading,
                'expireTime' => \Yii::$app->formatter->asDatetime($result->expire_at_reading, 'php:m-d-Y H:i:s'),
                'price' => $result->price,
                'part' => $result->getUsedCountReading()
            ],
            'data' => $result->questionsReading,
        ]);
    }

}