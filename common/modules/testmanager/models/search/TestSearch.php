<?php

namespace common\modules\testmanager\models\search;

use common\modules\testmanager\models\Test;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SubjectSearch represents the model behind the search form of `backend\modules\testmanager\models\Subject`.
 */
class TestSearch extends Test
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_free', 'price', 'status', 'show_answer', 'tests_count', 'duration'], 'integer'],
            [['name', 'started_at', 'finished_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($query = null, $params = null, $pagination = 20)
    {
        if ($query === null) {
            $query = Test::find();
        }
        if ($params === null) {
            $params = \Yii::$app->request->queryParams;
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pagination
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->started_at)) {
            $dates = explode(' - ', $this->started_at, 2);
            if (count($dates) == 2) {
                $begin = strtotime($dates[0]);
                $end = strtotime('+1 day', strtotime($dates[1]));
                $query->andFilterWhere(['>=', 'test.started_at', $begin])
                    ->andFilterWhere(['<', 'test.started_at', $end]);
            }
        }
        if (!empty($this->finished_at)) {
            $dates = explode(' - ', $this->finished_at, 2);
            if (count($dates) == 2) {
                $begin = strtotime($dates[0]);
                $end = strtotime('+1 day', strtotime($dates[1]));
                $query->andFilterWhere(['>=', 'test.finished_at', $begin])
                    ->andFilterWhere(['<', 'test.finished_at', $end]);
            }
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_free' => $this->is_free,
            'price' => $this->price,
            'tests_count' => $this->tests_count,
            'duration' => $this->duration,
            'status' => $this->status,
            'show_answer' => $this->show_answer,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
