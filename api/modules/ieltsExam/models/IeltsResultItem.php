<?php

namespace api\modules\ieltsExam\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class IeltsResultItem extends \common\modules\ieltsExam\models\IeltsResultItem
{
    public function upload(UploadedFile $answerFile, int $exam_id): bool
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$answerFile) {
                throw new \Exception(Yii::t('app', 'Audio file not uploaded'));
            }

            $userId = Yii::$app->user->id;
            $examId = $exam_id;

            // Define the audio directory path
            $audioDirectory = Yii::getAlias("@frontend/web/uploads/ielts/speaking-answers/user_$userId/exam_$examId/");

            // Create directory if it doesn't exist
            if (!is_dir($audioDirectory)) {
                FileHelper::createDirectory($audioDirectory, 0775, true);
            }

            // Generate a unique file path
            $audioPath = $audioDirectory . uniqid() . '.' . $answerFile->extension;

            // Save the file
            if (!$answerFile->saveAs($audioPath)) {
                throw new \Exception(Yii::t('app', 'Failed to save audio file'));
            }

            // Save the relative path in the model
            $this->value = str_replace(Yii::getAlias('@frontend/web'), '', $audioPath);

            // Save the model
            if (!$this->save()) {
                throw new \Exception(Yii::t('app', 'Failed to save model'));
            }

            // Commit the transaction
            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->addError('value', $e->getMessage());
            return false;
        }
    }
}