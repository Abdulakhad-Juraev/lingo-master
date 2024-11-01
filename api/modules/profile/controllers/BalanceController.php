<?php

namespace api\modules\profile\controllers;

use api\controllers\ApiBaseController;
use common\modules\usermanager\models\search\UserPaymentSearch;
use common\modules\usermanager\models\UserPayment;

class BalanceController extends ApiBaseController
{
    public $authRequired = true;

    public function actionIndex(): array
    {
        $user_id = \Yii::$app->user->identity->getId();
        $query = UserPayment::find()
            ->andWhere(['user_id' => $user_id])
            ->orderBy('created_at DESC');
        $searchModel = new UserPaymentSearch();
        $dataProvider = $searchModel->search($query);
        return $this->success($dataProvider);
    }
}