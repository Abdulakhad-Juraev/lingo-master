<?php

namespace api\modules\ieltsExam\models;

use common\modules\ieltsExam\models\IeltsOptions;
use soft\db\ActiveQuery;

class IeltsQuestions extends \common\modules\ieltsExam\models\IeltsQuestions
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
            'type_id',
            'options' => function (IeltsQuestions $question) {
                return $question->ieltsOptions;
            }
        ];
    }

    public function getIeltsOptions(): ActiveQuery
    {
        IeltsOptions::setFields([
            'id',
            'text'
        ]);
        return $this->hasMany(IeltsOptions::className(), ['question_id' => 'id']);

    }
}