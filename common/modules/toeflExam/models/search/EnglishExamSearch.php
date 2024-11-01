<?php

namespace common\modules\toeflExam\models\search;

use common\modules\toeflExam\models\EnglishExam;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class EnglishExamSearch extends EnglishExam
{

    public function rules()
    {
        return [
            [['id', 'price', 'number_attempts', 'type', 'reading_duration', 'listening_duration', 'writing_duration', 'speaking_duration', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['short_description', 'title', 'img'], 'safe'],
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
            $query = EnglishExam::find();
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
            'price' => $this->price,
            'number_attempts' => $this->number_attempts,
            'type' => $this->type,
            'reading_duration' => $this->reading_duration,
            'listening_duration' => $this->listening_duration,
            'writing_duration' => $this->writing_duration,
            'speaking_duration' => $this->speaking_duration,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'short_description', $this->short_description])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'reading_duration', $this->reading_duration])
            ->andFilterWhere(['like', 'listening_duration', $this->listening_duration])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'img', $this->img]);

        return $dataProvider;
    }
}
