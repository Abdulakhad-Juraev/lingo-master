<?php

namespace api\modules\toefl\models;

use common\modules\toeflExam\models\ToeflListeningGroup;

class ListeningGroup extends ToeflListeningGroup
{
    public function fields()
    {

        return [
            'id',
            'audio' => function (ListeningGroup $model) {
                return $model->audioUrl;
            },
            'questions' => function (ListeningGroup $model) {
                return $model->toeflQuestions;
            }
        ];


    }

    public function getToeflQuestions()
    {
        ToeflQuestion::setFields([
            'question_id' => function ($model) {
                return $model->id;
            },
            'options' => function ($model) {
                return $model->toeflOptions;
            }
        ]);
        return $this->hasMany(ToeflQuestion::className(), ['listening_group_id' => 'id'])->with('toeflOptions');
    }
}