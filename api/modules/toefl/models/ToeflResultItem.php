<?php

namespace api\modules\toefl\models;

class ToeflResultItem extends \common\modules\toeflExam\models\ToeflResultItem
{
    public function fields()
    {
        $key = self::generateFieldParam();
        if (isset(self::$fields[$key])) {
            return self::$fields[$key];
        }

        return [
            'question' => function (ToeflResultItem $model) {
                return $model->question->value;
            },
            'question_id',
            'options' => function (ToeflResultItem $model) {
                return $model->question->toeflOptions;
            },
            'user_answer_id',
            'is_correct',
//            'options' => function (ToeflResultItem $model) {
//                return $model->userQuestion->userOptions;
//            },
            'original_answer_id' => function (ToeflResultItem $model) {
                if ($this->result->status === ToeflResult::STATUS_INACTIVE) {
                    return $this->original_answer_id;
                }
                return '';
            }
        ];
    }

}