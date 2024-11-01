<?php

namespace api\modules\testmanager\models;

class Question extends \common\modules\testmanager\models\Question
{
    public function fields()
    {
        $key = self::generateFieldParam();

        if (isset(self::$fields[$key])) {
            return self::$fields[$key];
        }

        return [
            'id',
            'title',
        ];
    }

}