<?php

namespace common\modules\ieltsExam\models\search;

use common\modules\ieltsExam\models\IeltsResult;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class IeltsResultSearch extends IeltsResult
{

    public $full_name;

    public function rules()
    {
        return [
            [['id', 'exam_id', 'started_at_listening', 'started_at_reading', 'started_at_writing', 'started_at_speaking', 'expired_at', 'expired_at_listening', 'expired_at_reading', 'expired_at_writing', 'expired_at_speaking', 'listening_duration', 'reading_duration', 'writing_duration', 'speaking_duration', 'correct_answers_listening', 'correct_answers_reading', 'step', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'price', 'finished_at_listening', 'finished_at_writing', 'finished_at_reading', 'finished_at_speaking'], 'integer'],
            [['listening_score', 'started_at', 'finished_at', 'reading_score', 'writing_score', 'speaking_score'], 'number'],
            [['user_id','started_at', 'finished_at'], 'safe'],
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
            $query = IeltsResult::find();
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

        if (!empty($this->started_at)) {
            $dates = explode(' - ', $this->started_at, 2);
            if (count($dates) == 2) {
                $begin = strtotime($dates[0]);
                $end = strtotime('+1 day', strtotime($dates[1]));
                $query->andFilterWhere(['>=', 'ielts_result.started_at', $begin])
                    ->andFilterWhere(['<', 'ielts_result.started_at', $end]);
            }
        }
        if (!empty($this->finished_at)) {
            $dates = explode(' - ', $this->finished_at, 2);
            if (count($dates) == 2) {
                $begin = strtotime($dates[0]);
                $end = strtotime('+1 day', strtotime($dates[1]));
                $query->andFilterWhere(['>=', 'ielts_result.finished_at', $begin])
                    ->andFilterWhere(['<', 'ielts_result.finished_at', $end]);
            }
        }

        // Additional filters
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'exam_id' => $this->exam_id,
            'started_at_listening' => $this->started_at_listening,
            'started_at_reading' => $this->started_at_reading,
            'started_at_writing' => $this->started_at_writing,
            'started_at_speaking' => $this->started_at_speaking,
            'expired_at' => $this->expired_at,
            'expired_at_listening' => $this->expired_at_listening,
            'expired_at_reading' => $this->expired_at_reading,
            'expired_at_writing' => $this->expired_at_writing,
            'expired_at_speaking' => $this->expired_at_speaking,
            'listening_duration' => $this->listening_duration,
            'reading_duration' => $this->reading_duration,
            'writing_duration' => $this->writing_duration,
            'speaking_duration' => $this->speaking_duration,
            'correct_answers_listening' => $this->correct_answers_listening,
            'correct_answers_reading' => $this->correct_answers_reading,
            'listening_score' => $this->listening_score,
            'reading_score' => $this->reading_score,
            'writing_score' => $this->writing_score,
            'speaking_score' => $this->speaking_score,
            'step' => $this->step,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'price' => $this->price,
            'finished_at_listening' => $this->finished_at_listening,
            'finished_at_writing' => $this->finished_at_writing,
            'finished_at_reading' => $this->finished_at_reading,
            'finished_at_speaking' => $this->finished_at_speaking,
        ]);

        $query->joinWith('user');
        $query->andFilterWhere(['like', 'user.full_name', $this->full_name]);

        return $dataProvider;

    }
}
