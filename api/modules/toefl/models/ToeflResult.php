<?php

namespace api\modules\toefl\models;


use common\modules\toeflExam\models\ToeflResultQuestion;
use yii\db\ActiveQuery;

class ToeflResult extends \common\modules\toeflExam\models\ToeflResult
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
            'examName' => function (ToeflResult $model) {
                return $model->exam->title ?? '';
            },
            'started_at',
            'startedTime' => function (ToeflResult $model) {
                return \Yii::$app->formatter->asDatetime($model->started_at, 'php:d-m-Y H:i:s');
            },
            'price',
            'finished_at',
            'finishedTime' => function (ToeflResult $model) {
                return $model->finished_at ? \Yii::$app->formatter->asDatetime($model->finished_at, 'php:d-m-Y H:i:s') : '';
            },
            'result' => function (ToeflResult $model) {
                return $model->getToeflResult();
            }
        ];
    }

    public function getToeflResultItems()
    {
        return $this->hasMany(ToeflResultItem::class, ['result_id' => 'id']);
    }

    public function getQuestionsListening()
    {

        // Set the fields for ToeflListeningGroup
        ListeningGroup::setFields(
            [
                'id',
                'audio' => function (ListeningGroup $model) {
                    return $model->audioUrl;
                },
                'questions' => function (ListeningGroup $model) {
                    return $model->toeflQuestions;
                }
            ]
        );
        // Find the listening groups that are associated with the result items
        return ListeningGroup::find()
            ->with('toeflQuestions')
            ->andWhere(['in', 'id',
                ToeflResultQuestion::find()->select('l_group_id')
                    ->andWhere(['result_id' => $this->id])
                    ->andWhere(['is_used' => ToeflResultQuestion::IS_USED_FALSE])
            ])
            ->one();
    }

    public function getQuestionsReading()
    {
        // Find the listening groups that are associated with the result items
        return ToeflReadingGroup::find()
            ->with('toeflQuestions')
            ->andWhere(['in', 'id',
                ToeflResultQuestion::find()->select('r_group_id')
                    ->andWhere(['result_id' => $this->id])
                    ->andWhere(['is_used' => ToeflResultQuestion::IS_USED_FALSE])
            ])
            ->one();
    }

    public function getWritingQuestions(): ActiveQuery
    {
        ToeflQuestion::setFields([
            'question_id' => function (ToeflQuestion $model) {
                return $model->id;
            },
            'value',
            'options' => function (ToeflQuestion $question) {
                return $question->toeflOptions;
            }
        ]);
        return $this->hasMany(ToeflQuestion::class, ['id' => 'question_id'])
            ->andWhere(['toefl_question.type_id' => ToeflQuestion::TYPE_WRITING])
            ->with('toeflOptions')
            ->via('toeflResultItemsWriting')
            ->limit(5);
    }

    public function getUsedCountListening()
    {
        return ToeflResultQuestion::find()
            ->where(['result_id' => $this->id])
            ->andWhere(['is not', 'l_group_id', null])
            ->andWhere(['user_id' => $this->user_id])
            ->andWhere(['is_used' => ToeflResultQuestion::IS_USED_TRUE])
            ->count();
    }
    public function getUsedCountReading()
    {
        return ToeflResultQuestion::find()
            ->where(['result_id' => $this->id])
            ->andWhere(['is not', 'r_group_id', null])
            ->andWhere(['user_id' => $this->user_id])
            ->andWhere(['is_used' => ToeflResultQuestion::IS_USED_TRUE])
            ->count();
    }

}