<?php

namespace api\modules\ieltsExam\controllers;

use api\controllers\ApiBaseController;
use api\models\User;
use api\modules\ieltsExam\models\IeltsResult;
use api\modules\ieltsExam\models\IeltsResultItem;
use api\modules\toefl\models\EnglishExam;
use Yii;
use yii\web\UploadedFile;

class SpeakingController extends ApiBaseController
{
    public $authRequired = true;

    public function actionStart(int $exam_id)
    {
        /** @var User $user */
        $user = \Yii::$app->user->identity;
        $result = $user->activeIeltsTest;
        $exam = EnglishExam::findModel($exam_id);
        if (!$result) {
            return $this->error(t('Result not found!'));
        }
        if ($result) {
            $check = $result->getCheckResultStatus($exam->id);
            if (!empty($check)) {
                return $this->error($check['message'], $check['code']);
            }
            if (isset($result->started_at_speaking)) {
                return $this->fetchTestResultData($result);
            }
        }
        $prepareQuestions = $exam->prepareQuestionSpeakingIelts();
        if (empty($prepareQuestions)) {
            return $this->error(t('There is currently no active test'));
        }
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $resultItems = [];
            foreach ($prepareQuestions as $prepareQuestion) {
                $resultItems[] = [
                    'result_id' => $result->id,
                    'question_id' => $prepareQuestion->id,
                    'type_id' => IeltsResultItem::TYPE_SPEAKING,
                    'input_type' => $prepareQuestion->type_id
                ];
            }
            $result->started_at_speaking = time();
            $result->expired_at_speaking = strtotime('+' . $exam->speaking_duration . ' minute');
            $result->save();
            Yii::$app->db->createCommand()
                ->batchInsert(IeltsResultItem::tableName(), ['result_id', 'question_id', 'type_id', 'input_type'], $resultItems)
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
        $post = Yii::$app->request->post();
        $examId = (int)$post['exam_id'] ?? null;
        $question_id = $post['question_id'] ?? null;

        // Handle file upload
        $uploadedFile = UploadedFile::getInstanceByName('audio'); // 'audio' should match the name attribute in your HTML form

        $user = \Yii::$app->user->identity;
        /** @var IeltsResult $result */
        $result = $user->activeIeltsTest;
        /** @var IeltsResultItem $resultItem */
        $resultItem = IeltsResultItem::find()
            ->andWhere(['result_id' => $result->id, 'question_id' => $question_id])
            ->one();

        if (!$resultItem) {
            return $this->error(Yii::t('app', 'Question not found!'));
        }
        if (!$result || $result->exam_id !== $examId) {
            return $this->error('No active result found for the exam');
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $resultItem->is_used = 1;

            // Use the upload method from the IeltsResultItem model to handle file saving
            if (!$resultItem->upload($uploadedFile, $examId)) {
                $transaction->rollBack();
                return $this->error($resultItem->firstErrorMessage);
            }

            // Check if speaking questions are available and not expired
            if (!empty($result->speakingQuestions) && ($result->expired_at_speaking >= time())) {
                $transaction->commit();
                return $this->fetchTestResultData($result);
            }

            // Finish the speaking section and the exam
            $result->finished_at_speaking = time();
            $result->finished_at = time();
            $result->step = IeltsResult::STEP_FINISHED;

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

    private function fetchTestResultData($result)
    {
        /** @var IeltsResult $result */
        return $this->success([
            'test' => [
                'id' => $result->id,
                'exam_id' => $result->exam_id,
                'title' => $result->exam->title,
                'started_at_speaking' => $result->started_at_speaking,
                'startedTime' => \Yii::$app->formatter->asDatetime($result->started_at_speaking, 'php:d-m-Y H:i:s'),
                'expire_at_speaking' => $result->expired_at_speaking,
                'expireTime' => \Yii::$app->formatter->asDatetime($result->expired_at_speaking, 'php:m-d-Y H:i:s'),
            ],
            'data' => $result->speakingQuestions,
        ]);
    }


}