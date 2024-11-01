<?php

namespace api\models;

class TestList extends \common\models\TestList
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
            'title',
            'description',
            'imageUrl' => function (TestList $model) {
                return $model->getImageUrl();
            }
        ];
    }
}