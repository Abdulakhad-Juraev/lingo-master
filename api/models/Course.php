<?php

namespace api\models;

class Course extends \common\modules\university\models\Course
{
    public function fields()
    {
        $key = self::generateFieldParam();
        if (isset(self::$fields[$key])) {
            return self::$fields[$key];
        }
        return [];
    }
}