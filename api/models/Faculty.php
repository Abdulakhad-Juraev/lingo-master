<?php

namespace api\models;

class Faculty extends \common\modules\university\models\Faculty
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