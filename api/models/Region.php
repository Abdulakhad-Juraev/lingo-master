<?php

namespace api\models;

class Region extends \common\modules\regionmanager\models\Region
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