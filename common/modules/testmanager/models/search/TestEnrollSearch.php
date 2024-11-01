<?php

namespace common\modules\testmanager\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\testmanager\models\TestEnroll;

class TestEnrollSearch extends TestEnroll
{

    public function rules()
    {
        return [
            [['id', 'test_id', 'user_id', 'payment_type_id', 'price', 'count'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($query=null, $defaultPageSize = 20, $params=null)
    {

        if($params === null){
            $params = Yii::$app->request->queryParams;
        }
        if($query == null){
            $query = TestEnroll::find();
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
            'test_id' => $this->test_id,
            'user_id' => $this->user_id,
            'payment_type_id' => $this->payment_type_id,
            'price' => $this->price,
            'count' => $this->count,
        ]);

        return $dataProvider;
    }
}
