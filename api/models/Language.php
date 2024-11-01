<?php

namespace api\models;

class Language extends \common\modules\university\models\Language
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