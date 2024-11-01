<?php

namespace api\models;

class Subject extends \common\modules\testmanager\models\Subject
{
    public function fields()
    {
        $key = self::generateFieldParam();
        if (isset(self::$fields[$key])) {
            return self::$fields[$key];
        }
        return [
            'id',
            'name',
        ];
    }

}