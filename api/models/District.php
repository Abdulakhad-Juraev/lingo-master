<?php

namespace api\models;

class District extends \common\modules\regionmanager\models\District
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