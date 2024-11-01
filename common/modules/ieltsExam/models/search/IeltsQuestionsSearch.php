<?php

namespace common\modules\ieltsExam\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\ieltsExam\models\IeltsQuestions;

class IeltsQuestionsSearch extends IeltsQuestions
{

    public function rules()
    {
        return [
            [['id', 'question_group_id', 'exam_id', 'type_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['value', 'info', 'section'], 'safe'],
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
            $query = IeltsQuestions::find();
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
            'question_group_id' => $this->question_group_id,
            'exam_id' => $this->exam_id,
            'section' => $this->section,
            'type_id' => $this->type_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'info', $this->info]);

        return $dataProvider;
    }
}
