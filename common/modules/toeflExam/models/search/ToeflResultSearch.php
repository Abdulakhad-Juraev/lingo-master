<?php

namespace common\modules\toeflExam\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\toeflExam\models\ToeflResult;

class ToeflResultSearch extends ToeflResult
{

    public function rules()
    {
        return [
            [['id', 'user_id', 'exam_id', 'started_at', 'started_at_listening', 'started_at_reading', 'started_at_writing', 'expire_at', 'expire_at_listening', 'expire_at_reading', 'expire_at_writing', 'reading_duration', 'writing_duration', 'listening_duration', 'correct_answers_listening', 'correct_answers_reading', 'correct_answers_writing', 'price', 'finished_at', 'finished_at_listening', 'finished_at_reading', 'finished_at_writing', 'step', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['listening_score', 'reading_score', 'writing_score'], 'number'],
            [['cefr_level'], 'safe'],
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
            $query = ToeflResult::find();
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
            'exam_id' => $this->exam_id,
            'started_at' => $this->started_at,
            'started_at_listening' => $this->started_at_listening,
            'started_at_reading' => $this->started_at_reading,
            'started_at_writing' => $this->started_at_writing,
            'expire_at' => $this->expire_at,
            'expire_at_listening' => $this->expire_at_listening,
            'expire_at_reading' => $this->expire_at_reading,
            'expire_at_writing' => $this->expire_at_writing,
            'reading_duration' => $this->reading_duration,
            'writing_duration' => $this->writing_duration,
            'listening_duration' => $this->listening_duration,
            'correct_answers_listening' => $this->correct_answers_listening,
            'correct_answers_reading' => $this->correct_answers_reading,
            'correct_answers_writing' => $this->correct_answers_writing,
            'price' => $this->price,
            'finished_at' => $this->finished_at,
            'finished_at_listening' => $this->finished_at_listening,
            'finished_at_reading' => $this->finished_at_reading,
            'finished_at_writing' => $this->finished_at_writing,
            'step' => $this->step,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'listening_score' => $this->listening_score,
            'reading_score' => $this->reading_score,
            'writing_score' => $this->writing_score,
        ]);

        $query->andFilterWhere(['like', 'cefr_level', $this->cefr_level]);

        return $dataProvider;
    }
}
