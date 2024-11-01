<?php

namespace api\models;

class CompanyInfo extends \common\models\CompanyInfo
{
    public function fields()
    {
        return [
            'id',
            'logoUrl' => function (CompanyInfo $model) {
                return $model->getFileUrl();
            },
            'instagram',
            'telegram',
            'facebook',
            'youtube',
            'twitter'
        ];
    }
}