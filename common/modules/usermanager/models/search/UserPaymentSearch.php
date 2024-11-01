<?php

namespace common\modules\usermanager\models\search;

use common\traits\RangeFilterable;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\usermanager\models\UserPayment;

class UserPaymentSearch extends UserPayment
{
    use RangeFilterable;

    public function rules()
    {
        return array_merge([
            [['id', 'user_id', 'amount', 'transaction_id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'value'], 'integer'],
            [['comment', 'type_id'], 'safe'],
        ], $this->getRangeValidatorRule());
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($query = null, $defaultPageSize = 20, $params = null)
    {

        if ($params === null) {
            $params = Yii::$app->request->queryParams;
        }
        if ($query == null) {
            $query = UserPayment::find();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $defaultPageSize,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'transaction_id' => $this->transaction_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'type_id', $this->type_id]);

        return $dataProvider;
    }
}
