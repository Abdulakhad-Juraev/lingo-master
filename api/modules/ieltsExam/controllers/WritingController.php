<?php

namespace api\modules\ieltsExam\controllers;

use api\controllers\ApiBaseController;
use api\models\User;
use api\modules\ieltsExam\models\IeltsQuestionGroup;
use api\modules\ieltsExam\models\IeltsResult;
use api\modules\toefl\models\EnglishExam;
use common\modules\ieltsExam\models\IeltsResultItem;
use Yii;

class WritingController extends ApiBaseController
{
    public $authRequired = true;

    public function actionStart($exam_id)
    {
        /** @var User $user */
        $user = \Yii::$app->user->identity;
        $result = $user->activeIeltsTest;
        $exam = EnglishExam::findModel($exam_id);

        if (!$result) {
            return $this->error('Result not found');
        }

        $check = $result->getCheckResultStatus($exam->id);
        if (!empty($check)) {
            return $this->error($check['message'], $check['code']);
        }

        if (isset($result->started_at_writing)) {
            return $this->fetchTestResultData($result);
        }

        $prepareQuestions = $exam->prepareQuestionWritingIelts();
        if (empty($prepareQuestions)) {
            return $this->error('There is currently no active test');
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $resultItems = [];
            /** @var IeltsQuestionGroup $prepareQuestion */
            foreach ($prepareQuestions as $prepareQuestion) {
                $resultItems[] = [
                    'result_id' => $result->id,
                    'question_id' => $prepareQuestion->id,
                    'type_id' => IeltsResultItem::TYPE_WRITING,
                    'input_type' => $prepareQuestion->type_id,
                ];
            }
            $result->started_at_writing = time();
            $result->expired_at_writing = strtotime('+' . $exam->writing_duration . ' minutes');
            if (!$result->save()) {
                $transaction->rollBack();
                return $this->error('Failed to save test result');
            }

            Yii::$app->db->createCommand()
                ->batchInsert(IeltsResultItem::tableName(), ['result_id', 'question_id', 'type_id', 'input_type'], $resultItems)
                ->execute();
            $transaction->commit();
            return $this->fetchTestResultData($result);
        } catch (\Throwable $e) {
            $transaction->rollBack();
            return $this->error('Transaction failed: ' . $e->getMessage());
        }
    }

    public function actionNext()
    {
        $json = json_decode(Yii::$app->request->rawBody, true);
        if ($json === null) {
            return $this->error('Invalid JSON data received');
        }

        $examId = $json['exam_id'] ?? null;
        $answer = $json['answers'] ?? null;
        $result = user()->activeIeltsTest;
        if (!$result || $result->exam_id !== $examId) {
            return $this->error('No active result found for the exam');
        }
        if (empty($answer)) {
            return $this->error('No answers provided');
        }
        /** @var IeltsResultItem $resultItem */
        $resultItem = IeltsResultItem::find()
            ->andWhere(['result_id' => $result->id, 'question_id' => $answer['question_id'] ?? null])
            ->one();
        if (!$resultItem) {
            return $this->error('Savol topilmadi');
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $resultItem->is_used = 1;
            $resultItem->value = $answer['option_id'];
            if (!$resultItem->save()) {
                $transaction->rollBack();
                return $this->error($resultItem->firstErrorMessage);
            }
            if (!empty($result->writingQuestions) && ($result->expired_at_writing >= time())) {
                $transaction->commit();
                return $this->fetchTestResultData($result);
            }
            $result->finished_at_writing = time();
            $result->step = IeltsResult::STEP_SPEAKING;
            if (!$result->save()) {
                $transaction->rollBack();
                return $this->error($result->firstErrorMessage);
            }
            $transaction->commit();
            return $this->success();
        } catch (\Exception $e) {
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
                'started_at_writing' => $result->started_at_writing,
                'startedTime' => \Yii::$app->formatter->asDatetime($result->started_at_writing, 'php:d-m-Y H:i:s'),
                'expire_at_writing' => $result->expired_at_writing,
                'expireTime' => \Yii::$app->formatter->asDatetime($result->expired_at_writing, 'php:m-d-Y H:i:s'),
            ],
            'data' => $result->writingQuestions,
        ]);
    }

}