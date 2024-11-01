<?php

namespace api\modules\ieltsExam\models;

use common\modules\ieltsExam\models\IeltsQuestionGroupResult;
use common\modules\ieltsExam\models\IeltsResultItem;
use soft\db\ActiveQuery;

class IeltsResult extends \common\modules\ieltsExam\models\IeltsResult
{
    public function fields()
    {
        $key = self::generateFieldParam();
        if (isset(self::$fields[$key])) {
            return self::$fields[$key];
        }
        return [
            'id',
            'exam_id',
            'examName' => function (IeltsResult $model) {
                return $model->exam->title ?? '';
            },
            'started_at',
            'startedTime' => function (IeltsResult $model) {
                return \Yii::$app->formatter->asDatetime($model->started_at, 'php:d-m-Y H:i:s');
            },
            'price',
            'finished_at',
            'finishedTime' => function (IeltsResult $model) {
                return $model->finished_at ? \Yii::$app->formatter->asDatetime($model->finished_at, 'php:d-m-Y H:i:s') : '';
            },
            'result' => function (IeltsResult $model) {
                return $model->getIeltsBandScore();
            }
        ];
    }

    public function getQuestionsGroup($type_id)
    {
        // Set the fields for ToeflListeningGroup
        IeltsQuestionGroup::setFields(
            [
                'id',
                'audio' => function ($model) {
                    return $model->audioUrl;
                },
                'questions' => function ($model) {
                    return $model->ieltsQuestions;
                }
            ]
        );
        // Find the listening groups that are associated with the result items
        return IeltsQuestionGroup::find()
            ->with('ieltsQuestions')
            ->andWhere(['in', 'id',
                IeltsQuestionGroupResult::find()->select('group_id')
                    ->andWhere(['result_id' => $this->id])
                    ->andWhere(['is_used' => IeltsQuestionGroupResult::IS_USED_FALSE])
            ])
            ->andWhere(['type_id' => $type_id])
            ->one();
    }

    public function getQuestionGroupOne($group_id)
    {
        return IeltsQuestionGroupResult::find()
            ->andWhere(['result_id' => $this->id])
            ->andWhere(['group_id' => $group_id])
            ->andWhere(['user_id' => $this->user_id])
            ->andWhere(['is_used' => IeltsQuestionGroupResult::IS_USED_FALSE])
            ->one();
    }

    public function getUsedCount($type_id)
    {
        return IeltsQuestionGroupResult::find()
            ->andWhere(['result_id' => $this->id])
            ->andWhere(['user_id' => $this->user_id])
            ->andWhere(['type_id' => $type_id])
            ->andWhere(['is_used' => IeltsQuestionGroupResult::IS_USED_TRUE])
            ->count();
    }


    public static function saveResult($exam, $step)
    {
        return new  self([
            'user_id' => \Yii::$app->user->identity->getId(),
            'exam_id' => $exam->id,
            'price' => $exam->price,
            'status' => self::STATUS_ACTIVE,
            'started_at' => time(),
            'started_at_listening' => time(),
            'reading_duration' => $exam->reading_duration,
            'listening_duration' => $exam->listening_duration,
            'writing_duration' => $exam->writing_duration,
            'speaking_duration' => $exam->speaking_duration,
            'expired_at_listening' => strtotime('+' . $exam->listening_duration . ' minute'),
            'expired_at' => strtotime('+' . ($exam->listening_duration + $exam->reading_duration + $exam->writing_duration + $exam->speaking_duration) . ' minute'),
            'step' => $step,
        ]);
    }

    public function getCheckResultStatus($exam_id)
    {

        $currentTime = time();

        if (($this->expired_at < $currentTime) || ($this->exam_id !== (int)$exam_id)) {
            return [
                'message' => 'You have an incomplete test',
                'code' => 420
            ];
        }
        $expiredSteps = [
            self::STEP_LISTENING => $this->expired_at_listening,
            self::STEP_READING => $this->expired_at_reading,
            self::STEP_WRITING => $this->expired_at_writing,
            self::STEP_SPEAKING => $this->expired_at_speaking,
        ];
        if (isset($expiredSteps[$this->step]) && $expiredSteps[$this->step] < $currentTime) {
            return [
                'message' => 'You have an incomplete test',
                'code' => 419
            ];
        }

        return [];
    }

    public function getIeltsResultItemsWritingSpeaking()
    {
        return $this->hasMany(IeltsResultItem::class, ['result_id' => 'id'])->andWhere(['is_used' => 0]);
    }

    public function getWritingQuestions(): ActiveQuery
    {
        IeltsQuestions::setFields([
            'question_id' => function (IeltsQuestions $model) {
                return $model->id;
            },
            'type_id',
            'value',
            'info',
        ]);
        return $this->hasMany(IeltsQuestions::class, ['id' => 'question_id'])
            ->andWhere(['group_type' => IeltsQuestions::TYPE_WRITING_GROUP])
            ->with('ieltsOptions')
            ->via('ieltsResultItemsWritingSpeaking')
            ->limit(1);
    }

    public function getSpeakingQuestions(): ActiveQuery
    {
        IeltsQuestions::setFields([
            'question_id' => function (IeltsQuestions $model) {
                return $model->id;
            },
            'type_id',
            'info',
            'section',
            'value' => function (IeltsQuestions $question) {
                return $question->getAudioUrl();
            },
        ]);
        return $this->hasMany(IeltsQuestions::class, ['id' => 'question_id'])
            ->andWhere(['group_type' => IeltsQuestions::TYPE_SPEAKING_GROUP])
            ->via('ieltsResultItemsWritingSpeaking')
            ->limit(1);

    }
}