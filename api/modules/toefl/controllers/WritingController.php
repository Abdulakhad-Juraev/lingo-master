<?php

namespace api\modules\toefl\controllers;

use api\controllers\ApiBaseController;
use api\modules\toefl\models\ToeflResult;
use common\modules\toeflExam\models\EnglishExam;
use common\modules\toeflExam\models\ToeflQuestion;
use common\modules\toeflExam\models\ToeflResultItem;

use Yii;

class WritingController extends ApiBaseController
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
        $currentTime = time();
        if (!$result) {
            return $this->error('Result topilmadi');
        }
        if ($result->expire_at < time()) {
            Yii::$app->response->statusCode = 420;
            return $this->error('You have an incomplete test', 420);
        }
        if ($result->expire_at_writing && $result->expire_at_writing < $currentTime) {
            Yii::$app->response->statusCode = 419;
            return $this->error('You have an incomplete test', 419);
        }
        if (isset($result->started_at_writing)) {
            return $this->fetchTestResultData($result);
        }
        $prepareQuestions = $exam->prepareQuestionWritingToefl();
        if (empty($prepareQuestions)) {
            return $this->error('There is currently no active test');
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $resultItems = [];
            $optionItems = [];
            /** @var ToeflQuestion $prepareQuestion */
            foreach ($prepareQuestions as $index => $prepareQuestion) {
                $resultItems[] = [
                    'result_id' => $result->id,
                    'question_id' => $prepareQuestion->id,
                    'original_answer_id' => $prepareQuestion->correctAnswer,
                    'type_id' => ToeflResultItem::TYPE_WRITING,
                ];
            }
            Yii::$app->db->createCommand()
                ->batchInsert(ToeflResultItem::tableName(), ['result_id', 'question_id', 'original_answer_id', 'type_id'], $resultItems)
                ->execute();
            $result->started_at_writing = time();
            $result->expire_at_writing = strtotime('+' . $exam->writing_duration . ' minute');
            if (!$result->save()) {
                throw new \Exception('Error saving results');
            }
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
        // Validate the decoded JSON
        if ($json === null) {
            return $this->error('Invalid JSON data received');
        }
        $userId = Yii::$app->user->id;
        $examId = $json['exam_id'] ?? null;
        $answers = $json['answers'] ?? [];
        // Fetch the TOEFL result for the current user and exam
        $result = user()->activeToeflTest;
        if (!$result || $result->exam_id !== $examId) {
            return $this->error('No active result found for the exam');
        }
        if (empty($answers)) {
            return $this->error('No answers provided');
        }
        // Fetch all ToeflResultItem records for the given result and index by question_id
        $resultItems = ToeflResultItem::find()
            ->andWhere(['result_id' => $result->id])
            ->indexBy('question_id')
            ->all();
        $casesUserAnswer = [];
        $casesIsCorrect = [];
        $casesIsUsed = [];
        $ids = [];
        foreach ($answers as $answerData) {
            $questionId = $answerData['question_id'];
            $optionId = $answerData['option_id'] ?? null;
            $resultItem = $resultItems[$questionId] ?? null;
            if (!$resultItem) {
                return $this->error('Question not found');
            }
            $isCorrect = ($optionId === $resultItem->original_answer_id) ? 1 : 0;
            $id = $resultItem->id;
            // If optionId is null, set userAnswerId to 'NULL' for SQL
            $userAnswerId = $optionId !== null ? $optionId : 'NULL';
            $casesUserAnswer[] = "WHEN {$id} THEN {$userAnswerId}";
            $casesIsCorrect[] = "WHEN {$id} THEN {$isCorrect}";
            $casesIsUsed[] = "WHEN {$id} THEN 1";
            $ids[] = $id;
        }
        if (empty($ids)) {
            return $this->error('No valid answers to save');
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $idsStr = implode(',', $ids);
            // Execute batch update SQL
            $sql = "UPDATE " . ToeflResultItem::tableName() . " SET 
            user_answer_id = CASE id " . implode(' ', $casesUserAnswer) . " END,
            is_correct = CASE id " . implode(' ', $casesIsCorrect) . " END,
            is_used = CASE id " . implode(' ', $casesIsUsed) . " END
            WHERE id IN ({$idsStr})";
            Yii::$app->db->createCommand($sql)->execute();
            // Optionally handle completion or fetch updated test result data
            /** @var ToeflResult $result */
            if (!empty($result->writingQuestions) && (strtotime(Yii::$app->formatter->asDatetime($result->expire_at_writing, 'php:d.m.Y H:i')) > time())) {
                $transaction->commit();
                return $this->fetchTestResultData($result);
            } else {
                $result->finished_at_writing = time();
                $result->correct_answers_writing = ToeflResultItem::find()
                    ->leftJoin('toefl_question', 'toefl_question.id = toefl_result_item.question_id')
                    ->andWhere(['toefl_question.type_id' => ToeflQuestion::TYPE_WRITING])
                    ->andWhere(['is_correct' => 1])
                    ->andWhere(['result_id' => $result->id])
                    ->count();
                $result->step = ToeflResult::STEP_READING;
                $result->save();
                $transaction->commit();
                return $this->success();
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->error($e->getMessage());
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
                'started_at_writing' => $result->started_at_writing,
                'startedTime' => \Yii::$app->formatter->asDatetime($result->started_at_writing, 'php:d-m-Y H:i:s'),
                'expire_at_writing' => $result->expire_at_writing,
                'expireTime' => \Yii::$app->formatter->asDatetime($result->expire_at_writing, 'php:m-d-Y H:i:s'),
            ],
            'data' => [
                'questions' => $result->writingQuestions
            ],
        ]);
    }
}