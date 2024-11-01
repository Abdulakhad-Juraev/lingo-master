<?php

namespace api\modules\ieltsExam\controllers;

use api\controllers\ApiBaseController;
use api\models\User;
use api\modules\ieltsExam\models\IeltsQuestionGroup;
use api\modules\ieltsExam\models\IeltsQuestions;
use api\modules\ieltsExam\models\IeltsResult;
use api\modules\toefl\models\EnglishExam;
use common\modules\ieltsExam\models\IeltsQuestionGroupResult;
use common\modules\ieltsExam\models\IeltsResultItem;
use Yii;

class ReadingController extends ApiBaseController
{
    public $authRequired = true;

    public function actionStart(int $exam_id)
    {
        /** @var User $user */
        $user = \Yii::$app->user->identity;
        $result = $user->activeIeltsTest;
        $exam = EnglishExam::findModel($exam_id);
        if (!$result) {
            return $this->error('Hozir sizda faol test yo\'q');
        }
        if ($result) {
            $check = $result->getCheckResultStatus($exam->id);
            if (!empty($check)) {
                return $this->error($check['message'], $check['code']);
            }
            if (isset($result->started_at_reading)) {
                return $this->fetchTestResultData($result);
            }
        }
        $prepareQuestions = $exam->prepareQuestionReadingIelts();
        if (empty($prepareQuestions)) {
            return $this->error(t('There is currently no active test'));
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $resultItems = [];
            $resultQuestionGroup = [];
            /** @var IeltsQuestionGroup $prepareQuestion */
            foreach ($prepareQuestions as $prepareQuestion) {
                $resultQuestionGroup[] = [
                    'group_id' => $prepareQuestion->id,
                    'result_id' => $result->id,
                    'user_id' => Yii::$app->user->identity->getId(),
                    'is_used' => IeltsQuestionGroupResult::IS_USED_FALSE,
                    'type_id' => IeltsQuestionGroupResult::TYPE_READING
                ];
                /** @var IeltsQuestions $ieltsQuestion */
                foreach ($prepareQuestion->ieltsQuestions as $ieltsQuestion) {
                    $resultItems[] = [
                        'result_id' => $result->id,
                        'question_id' => $ieltsQuestion->id,
                        'original_answer_id' => $ieltsQuestion->correctAnswer,
                        'type_id' => IeltsResultItem::TYPE_READING,
                        'input_type' => $ieltsQuestion->type_id,
                        'is_correct' => 0
                    ];
                }
            }
            $result->started_at_reading = time();
            $result->expired_at_reading = strtotime('+' . $exam->reading_duration . ' minute');
            $result->save();
            Yii::$app->db->createCommand()
                ->batchInsert(IeltsQuestionGroupResult::tableName(), ['group_id', 'result_id', 'user_id', 'is_used', 'type_id'], $resultQuestionGroup)
                ->execute();
            Yii::$app->db->createCommand()
                ->batchInsert(IeltsResultItem::tableName(), ['result_id', 'question_id', 'original_answer_id', 'type_id', 'input_type', 'is_correct'], $resultItems)
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
            return $this->error(t('Invalid JSON data received'));
        }
        $examId = $json['exam_id'] ?? null;
        $groupId = $json['group_id'] ?? null;
        $answers = $json['answers'] ?? [];
        $result = user()->activeIeltsTest;
        if (!$result || $result->exam_id !== $examId) {
            return $this->error('No active result found for the exam');
        }
        if (empty($answers)) {
            return $this->error(t('No answers provided'));
        }
        $resultQuestionGroup = $result->getQuestionGroupOne($groupId);
        if (!$resultQuestionGroup) {
            return $this->error(t('Question group not found or already used'));
        }
        $resultItems = IeltsResultItem::find()
            ->joinWith('question')
            ->andWhere(['result_id' => $result->id, 'ielts_questions.question_group_id' => $groupId])
            ->indexBy('question_id')
            ->all();

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $updateData = [
                'cases_user_answer' => '',
                'cases_is_correct' => '',
                'cases_value' => '',
                'ids' => []
            ];

            foreach ($answers as $answerData) {
                $questionId = $answerData['question_id'];
                $optionId = $answerData['option_id'] ?? null;
                $resultItem = $resultItems[$questionId] ?? null;

                if (!$resultItem) {
                    return $this->error(t("Result item for question ID $questionId not found"));
                }

                if ($resultItem->input_type === IeltsResultItem::INPUT_TYPE_TEXT) {
                    $isCorrect = ($optionId === trim(str_replace(["\r", "\n"], '', strip_tags($resultItem->originalAnswer->text)))) ? 1 : 0;
                    $userAnswerId = 'NULL';
                    $value = !empty($optionId) ? "'{$optionId}'" : 'NULL';
                } else {
                    $isCorrect = ($optionId === $resultItem->original_answer_id) ? 1 : 0;
                    $userAnswerId = $optionId !== null ? $optionId : 'NULL';
                    $value = 'NULL';
                }

                $id = $resultItem->id;

                $updateData['cases_user_answer'] .= "WHEN {$id} THEN {$userAnswerId} ";
                $updateData['cases_is_correct'] .= "WHEN {$id} THEN {$isCorrect} ";
                $updateData['cases_value'] .= "WHEN {$id} THEN {$value} ";
                $updateData['ids'][] = $id;
            }
            if (!empty($updateData['ids'])) {
                $idsStr = implode(',', $updateData['ids']);
                $sql = "UPDATE " . IeltsResultItem::tableName() . " SET 
            user_answer_id = CASE id {$updateData['cases_user_answer']} END,
            value = CASE id {$updateData['cases_value']} END,
            is_correct = CASE id {$updateData['cases_is_correct']} END
            WHERE id IN ({$idsStr})";

                Yii::$app->db->createCommand($sql)->execute();
            } else {
                return $this->error(t('No valid result items found for update'));
            }
            $resultQuestionGroup->is_used = 1;
            $resultQuestionGroup->save();
            if ($result->getQuestionsGroup(IeltsQuestionGroup::TYPE_READING) && (strtotime(Yii::$app->formatter->asDatetime($result->expired_at_reading, 'php:d.m.Y H:i')) > time())) {
                $questions = $this->fetchTestResultData($result);
                $transaction->commit();
                return $questions;
            }
            $result->finished_at_reading = time();
            $result->correct_answers_reading = IeltsResultItem::find()
                ->andWhere(['type_id' => IeltsResultItem::TYPE_READING])
                ->andWhere(['is_correct' => 1])
                ->andWhere(['result_id' => $result->id])
                ->count();
            $result->step = IeltsResult::STEP_WRITING;
            if (!$result->save()) {
                $transaction->rollBack();
                return $this->error($result->firstErrorMessage);
            }
            $transaction->commit();
            return $this->success();
        } catch
        (\Exception $e) {
            $transaction->rollBack();
            return $this->error($e->getMessage());
        }
    }


    private function fetchTestResultData($result): array
    {
        /** @var IeltsResult $result */
        return $this->success([
            'test' => [
                'id' => $result->id,
                'exam_id' => $result->exam_id,
                'title' => $result->exam->title,
                'started_at_reading' => $result->started_at_reading,
                'startedTime' => \Yii::$app->formatter->asDatetime($result->started_at_reading, 'php:d-m-Y H:i:s'),
                'expired_at_reading' => $result->expired_at_reading,
                'expireTime' => \Yii::$app->formatter->asDatetime($result->expired_at_reading, 'php:m-d-Y H:i:s'),
                'part' => $result->getUsedCount(IeltsQuestionGroupResult::TYPE_READING)
            ],
            'data' => $result->getQuestionsGroup(IeltsQuestionGroup::TYPE_READING),
        ]);
    }

}