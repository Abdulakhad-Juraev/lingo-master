<?php

namespace api\modules\toefl\controllers;

use api\controllers\ApiBaseController;

use api\modules\toefl\models\ToeflResult;
use common\models\User;
use common\modules\testmanager\models\TestResultItem;
use common\modules\toeflExam\models\EnglishExam;

use common\modules\toeflExam\models\ToeflListeningGroup;
use common\modules\toeflExam\models\ToeflQuestion;
use common\modules\toeflExam\models\ToeflResultItem;
use common\modules\toeflExam\models\ToeflResultQuestion;
use Yii;
use yii\web\ForbiddenHttpException;

class ListeningController extends ApiBaseController
{
    public $authRequired = true;

    public function actionListening(int $exam_id)
    {
        /** @var EnglishExam $exam */
        $exam = EnglishExam::findOne($exam_id);
        /** @var User $user */
        $user = Yii::$app->user->identity;
        if (!$exam) {
            return $this->error('Invalid exam ID');
        }
        /** @var ToeflResult $result */
        $result = user()->activeToeflTest;
        $currentTime = time();
        if ($result) {
            if ($result->step !== ToeflResult::STEP_LISTENING) {
                Yii::$app->response->statusCode = 421;
                return $this->error('You are not at this stage', 421);
            }
            if ($result->expire_at < time() || $result->exam_id !== $exam_id) {
                Yii::$app->response->statusCode = 420;
                return $this->error('You have an incomplete test', 420);
            }
            if ($result->expire_at_listening < $currentTime) {
                Yii::$app->response->statusCode = 419;
                return $this->error('You have an incomplete test', 419);
            }
            return $this->fetchTestResultData($result);
        }
        $prepareQuestions = $exam->prepareQuestionListeningToefl();
        if (empty($prepareQuestions)) {
            return $this->error('There is currently no active test');
        }
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $result = new ToeflResult([
                'user_id' => \Yii::$app->user->identity->getId(),
                'exam_id' => $exam_id,
                'price' => $exam->price,
                'status' => ToeflResult::STATUS_ACTIVE,
                'started_at' => $currentTime,
                'started_at_listening' => $currentTime,
                'reading_duration' => $exam->reading_duration,
                'listening_duration' => $exam->listening_duration,
                'writing_duration' => $exam->writing_duration,
                'expire_at_listening' => strtotime('+' . $exam->listening_duration . ' minute'),
                'expire_at' => strtotime('+' . ($exam->listening_duration + $exam->reading_duration + $exam->writing_duration) . ' minute'),
                'step' => ToeflResult::STEP_LISTENING,
            ]);
            if (!$result->save()) {
                throw new \Exception('Error saving results');
            }
            $resultItems = [];
            $resultQuestionGroup = [];
            foreach ($prepareQuestions as $prepareQuestion) {
                $resultQuestionGroup[] = [
                    'l_group_id' => $prepareQuestion->id,
                    'result_id' => $result->id,
                    'user_id' => Yii::$app->user->identity->getId(),
                    'is_used' => ToeflResultQuestion::IS_USED_FALSE,
                ];
                foreach ($prepareQuestion->toeflQuestions as $toeflQuestion) {
                    $resultItems[] = [
                        'result_id' => $result->id,
                        'question_id' => $toeflQuestion->id,
                        'original_answer_id' => $toeflQuestion->correctAnswer,
                        'listening_group_id' => $prepareQuestion->id,
                        'type_id' => ToeflResultItem::TYPE_LISTENING
                    ];
                }
            }
            Yii::$app->db->createCommand()
                ->batchInsert(ToeflResultQuestion::tableName(), ['l_group_id', 'result_id', 'user_id', 'is_used'], $resultQuestionGroup)
                ->execute();
            Yii::$app->db->createCommand()
                ->batchInsert(ToeflResultItem::tableName(), ['result_id', 'question_id', 'original_answer_id', 'listening_group_id', 'type_id'], $resultItems)
                ->execute();
            $transaction->commit();
            return $this->fetchTestResultData($result);
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->error($e->getMessage());
        }
    }

    public function actionListeningAnswer()
    {
        $json = json_decode(Yii::$app->request->rawBody, true);
        if ($json === null) {
            return $this->error('Invalid JSON data received');
        }
        $userId = Yii::$app->user->id;
        $examId = $json['exam_id'] ?? null;
        $listeningGroupId = $json['listening_group_id'] ?? null;
        $answers = $json['answers'] ?? [];
        /** @var ToeflResult $result */
        $result = user()->activeToeflTest;
        if (!$result || $result->exam_id !== $examId) {
            return $this->error('No active result found for the exam');
        }
        if (empty($answers)) {
            return $this->error('Savollarga javob berilmadi');
        }
        $resultQuestionGroup = $this->getToeflResultQuestionGroup($listeningGroupId, $userId, $result->id);
        if (!$resultQuestionGroup) {
            return $this->error('Question group not found or already used');
        }
        $resultItems = $this->getResultItems($result->id, $listeningGroupId);
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
            if (!empty($result->questionsListening) && (strtotime(Yii::$app->formatter->asDatetime($result->expire_at_listening, 'php:d.m.Y H:i')))) {
                $transaction->commit();
                return  $this->fetchTestResultData($result);
            } else {
                $this->completeListeningStep($result);
                $transaction->commit();
                return $this->success();
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $this->error($e->getMessage());
        }
    }

    private function getToeflResultQuestionGroup($listeningGroupId, $userId, $result_id)
    {
        return ToeflResultQuestion::find()
            ->andWhere(['result_id' => $result_id])
            ->andWhere(['l_group_id' => $listeningGroupId])
            ->andWhere(['user_id' => $userId])
            ->andWhere(['is_used' => ToeflResultQuestion::IS_USED_FALSE])
            ->one();
    }

    private function getResultItems($resultId, $listeningGroupId)
    {
        return ToeflResultItem::find()
            ->andWhere(['result_id' => $resultId, 'listening_group_id' => $listeningGroupId])
            ->indexBy('question_id')
            ->all();
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

    private function completeListeningStep($result)
    {
        /** @var ToeflResult $result */
        $result->finished_at_listening = time();
        $result->correct_answers_listening = ToeflResultItem::find()
            ->leftJoin('toefl_question', 'toefl_question.id = toefl_result_item.question_id')
            ->andWhere(['toefl_question.type_id' => ToeflQuestion::TYPE_LISTENING])
            ->andWhere(['is_correct' => 1])
            ->andWhere(['result_id' => $result->id])
            ->count();
        $result->step = ToeflResult::STEP_WRITING;
        $result->save();
    }

    private function fetchTestResultData($result): array
    {
        /** @var ToeflResult $result */
        return $this->success([
            'test' => [
                'id' => $result->id,
                'exam_id' => $result->exam_id,
                'title' => $result->exam->title,
                'started_at_listening' => $result->started_at_listening,
                'startedTime' => \Yii::$app->formatter->asDatetime($result->started_at_listening, 'php:d-m-Y H:i:s'),
                'expire_at_listening' => $result->expire_at_listening,
                'expireTime' => \Yii::$app->formatter->asDatetime($result->expire_at_listening, 'php:m-d-Y H:i:s'),
                'price' => $result->price,
                'part' => $result->getUsedCountListening()
            ],
            'data' => $result->questionsListening,
        ]);
    }

}