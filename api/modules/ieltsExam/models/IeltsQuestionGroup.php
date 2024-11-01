<?php

namespace api\modules\ieltsExam\models;


class IeltsQuestionGroup extends \common\modules\ieltsExam\models\IeltsQuestionGroup
{
    public function fields()
    {

        return [
            'id',
            'audio' => function (IeltsQuestionGroup $model) {
                return $model->audioUrl;
            },
            'text' => function (IeltsQuestionGroup $model) {
                return $model->content;
            },
            'questions' => function (IeltsQuestionGroup $model) {
                return $model->ieltsQuestions;
            }
        ];


    }

    public function getIeltsQuestions(): \soft\db\ActiveQuery
    {
        IeltsQuestions::setFields([
            'question_id' => function (IeltsQuestions $model) {
                return $model->id;
            },
            'title' => function (IeltsQuestions $model) {
                return $model->value;
            },
            'type_id',
            'options' => function (IeltsQuestions $model) {
                return $model->ieltsOptions;
            }
        ]);
        return $this->hasMany(IeltsQuestions::className(), ['question_group_id' => 'id'])->with('ieltsOptions');
    }
}