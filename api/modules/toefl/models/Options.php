<?php

namespace api\modules\toefl\models;

use common\modules\toeflExam\models\ToeflOption;

class Options extends ToeflOption
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
            'is_correct',
            'text',
        ];
    }
}