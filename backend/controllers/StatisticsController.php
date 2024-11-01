<?php

namespace backend\controllers;

use common\modules\usermanager\models\Balance;
use frontend\web\controllers\BaseController;
use Yii;
use yii\helpers\ArrayHelper;

class StatisticsController extends BaseController
{
    /**
     * Displays homepage.
     *
     * @return string
     */

    public function actionBalance(): string
    {
        $get = Yii::$app->request->get();

        $from_date = \DateTime::createFromFormat('d-m-Y', $get['from_date'] ?? null);
        $to_date = \DateTime::createFromFormat('d-m-Y', $get['to_date'] ?? null);

        if (!($from_date && $to_date)) {
            $to_date = \DateTime::createFromFormat('d-m-Y', date('d-m-Y'));
            $from_date = \DateTime::createFromFormat('d-m-Y', date('d-m-Y'))->modify('-1 week');
        }
        $from_date = $from_date->setTime(0, 0, 0);
        $to_date = $to_date->setTime(23, 59, 59);

        $balanceIncome = Balance::find()
            ->select('SUM(value) as total')
            ->andWhere([
                'type' => Balance::TYPE_INCOME,
            ])
            ->andWhere(['between', 'created_at', $from_date->getTimestamp(), $to_date->getTimestamp()])
            ->asArray()
            ->one();

        $balanceExpense = Balance::find()
            ->select('SUM(value) as total')
            ->andWhere([
                'type' => Balance::TYPE_EXPENSE,
                'reason' => Balance::REASON_REDUCE_BALANCE_BY_ADMIN,
            ])
            ->andWhere(['between', 'created_at', $from_date->getTimestamp(), $to_date->getTimestamp()])
            ->asArray()
            ->one();

        $balanceUserIncome = Balance::find()
            ->select(['sum(value) as sum', 'balance.created_by', "full_name"])
            ->leftJoin('user', 'user.id = balance.created_by')
            ->andWhere([
                'balance.type' => Balance::TYPE_INCOME,
            ])
            ->andWhere(['between', 'balance.created_at', $from_date->getTimestamp(), $to_date->getTimestamp()])
            ->groupBy('created_by')
            ->orderBy('created_by')
            ->asArray()
            ->all();

        $balanceUserExpense = Balance::find()
            ->select(['sum(value) as sum', 'balance.created_by', "full_name"])
            ->leftJoin('user', 'user.id = balance.created_by')
            ->andWhere([
                'balance.type' => Balance::TYPE_EXPENSE,
                'balance.reason' => Balance::REASON_REDUCE_BALANCE_BY_ADMIN,
            ])
            ->andWhere(['between', 'balance.created_at', $from_date->getTimestamp(), $to_date->getTimestamp()])
            ->groupBy('created_by')
            ->orderBy('created_by')
            ->asArray()
            ->all();

        $income = ArrayHelper::map($balanceUserIncome, 'name', 'sum');
        $expense = ArrayHelper::map($balanceUserExpense, 'name', 'sum');

        $mergedIds = array_unique(array_merge(array_keys($income), array_keys($expense)));

        $balance = [];

        foreach ($mergedIds as $i) {
            if (isset($income[$i], $expense[$i])) {
                $balance[] = [
                    'user' => $i,
                    'in' => $income[$i],
                    'out' => $expense[$i],
                    'total' => (int)$income[$i] - (int)$expense[$i],
                ];
            } else if (isset($income[$i]) && !isset($expense[$i])) {
                $balance[] = [
                    'user' => $i,
                    'in' => $income[$i],
                    'out' => 0,
                    'total' => (int)$income[$i],
                ];
            } else {
                $balance[] = [
                    'user' => $i,
                    'in' => 0,
                    'out' => $expense[$i],
                    'total' => 0 - (int)$expense[$i],
                ];
            }
        }

        return $this->render('balance', [
            'from_date' => $from_date->format('d-m-Y'),
            'to_date' => $to_date->format('d-m-Y'),
            'balanceIncome' => $balanceIncome['total'],
            'balanceExpense' => $balanceExpense['total'],
            'balance' => $balance,
        ]);
    }
}