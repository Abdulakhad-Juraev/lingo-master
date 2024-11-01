<?php

namespace common\modules\ieltsExam\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\ieltsExam\models\IeltsResultItem;

/**
 * IeltsResultItemSearch represents the model behind the search form about `common\modules\ieltsExam\models\IeltsResultItem`.
 */
class IeltsResultItemSearch extends IeltsResultItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'result_id', 'question_id', 'user_answer_id', 'original_answer_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['is_correct', 'is_used', 'type_id', 'input_type', 'value'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
    public function search($query = null, $params = null)
    {
        if ($query === null) {
            $query = IeltsResultItem::find();
        }
        if ($params === null) {
            $params = Yii::$app->requestedParams;
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'result_id' => $this->result_id,
            'question_id' => $this->question_id,
            'user_answer_id' => $this->user_answer_id,
            'original_answer_id' => $this->original_answer_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'is_correct', $this->is_correct])
            ->andFilterWhere(['like', 'is_used', $this->is_used])
            ->andFilterWhere(['like', 'type_id', $this->type_id])
            ->andFilterWhere(['like', 'input_type', $this->input_type])
            ->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
