<?php

namespace api\models;

class Tariff extends \common\modules\tariff\models\Tariff
{
    public function fields()
    {
        $key = self::generateFieldParam();
        if (isset(self::$fields[$key])) {
            return self::$fields[$key];
        }
        return [
            'id',
            'price',
            'name',
            'short_description',
            'old_price',
        ];
    }
}