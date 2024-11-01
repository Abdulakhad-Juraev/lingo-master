<?php

namespace api\modules\toefl\models;

use common\modules\toeflExam\models\ToeflOption;
use yii\db\ActiveQuery;

class ToeflQuestion extends \common\modules\toeflExam\models\ToeflQuestion
{
    public function fields()
    {
        $key = self::generateFieldParam();
        if (isset(self::$fields[$key])) {
            return self::$fields[$key];
        }
        return [
            'id',
            'value',
            'options' => function (ToeflQuestion $question) {
                return $question->toeflOptions;
            }
        ];
    }

    public function getToeflOptions(): ActiveQuery
    {
        Options::setFields([
            'id',
            'text'
        ]);
        return $this->hasMany(Options::className(), ['toefl_question_id' => 'id']);

    }
}