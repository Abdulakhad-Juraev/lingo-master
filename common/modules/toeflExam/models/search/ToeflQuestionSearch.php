<?php

namespace common\modules\toeflExam\models\search;

use common\modules\toeflExam\models\ToeflQuestion;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ToeflQuestionSearch extends ToeflQuestion
{

    public function rules()
    {
        return [
            [['id', 'type_id', 'test_type_id', 'exam_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['value', 'title'], 'safe'],
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
            $query = ToeflQuestion::find();
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
            'type_id' => $this->type_id,
            'exam_id' => $this->exam_id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
