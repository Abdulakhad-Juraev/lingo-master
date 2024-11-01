<?php

namespace api\modules\toefl\models;

class ToeflReadingGroup extends \common\modules\toeflExam\models\ToeflReadingGroup
{
    public function fields()
    {

        return [
            'id',
            'text',
            'questions' => function (ToeflReadingGroup $model) {
                return $model->toeflQuestions;
            }
        ];


    }

    public function getToeflQuestions(): \soft\db\ActiveQuery
    {
        ToeflQuestion::setFields([
            'title' => function ($model) {
                return $model->value;
            },
            'question_id' => function ($model) {
                return $model->id;
            },
            'options' => function ($model) {
                return $model->toeflOptions;
            }
        ]);
        return $this->hasMany(ToeflQuestion::className(), ['reading_group_id' => 'id'])->with('toeflOptions');
    }
}