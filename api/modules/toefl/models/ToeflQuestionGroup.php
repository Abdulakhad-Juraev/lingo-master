<?php

namespace api\modules\toefl\models;

use common\modules\toeflExam\models\ToeflResultQuestion;

/**
 *
 * @property-read mixed $questionsListening
 */
class ToeflQuestionGroup extends ToeflResultQuestion
{
    public function fields()
    {
        $key = self::generateFieldParam();
        if (isset(self::$fields[$key])) {
            return self::$fields[$key];
        }
        return [
            'group' => function (ToeflQuestionGroup $model) {
                return $model->lGroup;
            }
        ];
    }

    public function getLGroup()
    {
        ListeningGroup::setFields([
            'id',
            'audio' => function ($model) {
                return $model->audioUrl;
            }
        ]);
        return $this->hasOne(ListeningGroup::className(), ['id' => 'l_group_id']);
    }

}