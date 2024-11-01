<?php

namespace common\models\search;

use common\modules\usermanager\models\Balance;
use common\traits\RangeFilterable;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BalanceSearch represents the model behind the search form of `common\models\Balance`.
 */
class BalanceSearch extends Balance
{
    use RangeFilterable;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return array_merge([
            [['id', 'user_id', 'type', 'value', 'total', 'reason', 'test_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['comment'], 'safe'],
        ], $this->getRangeValidatorRule());
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
/*    public function search(array $params,$query=null): ActiveDataProvider
    {
        if ($query===null){
            $query = Balance::find();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'value' => $this->value,
            'total' => $this->total,
            'reason' => $this->reason,
            'test_id' => $this->test_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);
        $this->addRangeFilter($query, 'balance');

        return $dataProvider;
    }*/

    public function search($query = null,$defaultPageSize = 20,$params = null)
    {

        if ($params === null) {
            $params = Yii::$app->request->queryParams;
        }
        if ($query == null) {
            $query = Balance::find();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $defaultPageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'value' => $this->value,
            'total' => $this->total,
            'reason' => $this->reason,
            'test_id' => $this->test_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);
        $this->addRangeFilter($query, 'balance');


        return $dataProvider;
    }
}
