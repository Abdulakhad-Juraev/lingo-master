<?php

namespace api\controllers;


use api\models\Tariff;

class TariffController extends ApiBaseController
{
    public function actionIndex()
    {
        return $this->success(Tariff::find()->andWhere(['status' => Tariff::STATUS_ACTIVE])->all());
    }
}