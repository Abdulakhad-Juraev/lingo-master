<?php

namespace api\modules\profile\models;

class Balance extends \common\modules\usermanager\models\Balance
{
    public function fields(): array
    {
        return [
            'id',
            'type',
            'typeName' => function (Balance $balance) {
                return $balance->typeName;
            },
            'value',
            'total',
            'reason',
            'reasonName' => function (Balance $balance) {
                return $balance->reasonName;
            },
            'comment',
            'test_id',
        ];
    }
}