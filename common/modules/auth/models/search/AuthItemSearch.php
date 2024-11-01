<?php

namespace common\modules\auth\models\search;

use common\modules\auth\models\AuthItem;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AuthItemSearch extends AuthItem
{
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['name', 'description'], 'safe'],
        ];
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
            $query = AuthItem::find();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $defaultPageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC,
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}