<?php

namespace api\models;

class Faq extends \common\models\Faq
{
    public function fields()
    {
        $key = self::generateFieldParam();
        if (isset(self::$fields[$key])) {
            return self::$fields[$key];
        }
        return [
            'id',
            'question',
            'answer',
        ];
    }
}