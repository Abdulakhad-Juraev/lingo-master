<?php

namespace common\modules\testmanager\models\search;

use common\modules\testmanager\models\TestResult;
use common\modules\university\models\Course;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TestResultSearch represents the model behind the search form about `backend\modules\testmanager\models\TestResult`.
 */
class TestResultSearch extends TestResult
{

    public $userFullName;
    public $course_id;
    public $faculty_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'duration', 'tests_count', 'correct_answers', 'expire_at', 'price'], 'integer'],
            [['status', 'userFullName', 'course_id', 'faculty_id', 'user_id', 'started_at', 'finished_at', 'test_id'], 'safe'],
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
    public function search($query = null, $defaultPageSize = 20, $params = null): ActiveDataProvider
    {
        if ($params === null) {
            $params = Yii::$app->request->queryParams;
        }
        if ($query == null) {
            $query = TestResult::find();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $defaultPageSize,
            ],
        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith(['user', 'test', 'user.course', 'user.faculty']);

        if (!empty($this->started_at)) {
            $dates = explode(' - ', $this->started_at, 2);
            if (count($dates) == 2) {
                $begin = strtotime($dates[0]);
                $end = strtotime('+1 day', strtotime($dates[1]));
                $query->andFilterWhere(['>=', 'test_result.started_at', $begin])
                    ->andFilterWhere(['<', 'test_result.started_at', $end]);
            }
        }
        if (!empty($this->finished_at)) {
            $dates = explode(' - ', $this->finished_at, 2);
            if (count($dates) == 2) {
                $begin = strtotime($dates[0]);
                $end = strtotime('+1 day', strtotime($dates[1]));
                $query->andFilterWhere(['>=', 'test_result.finished_at', $begin])
                    ->andFilterWhere(['<', 'test_result.finished_at', $end]);
            }
        }

        $query->andFilterWhere([
            'test_result.id' => $this->id,
            'test_result.created_at' => $this->created_at,
            'test_result.updated_at' => $this->updated_at,
            'test_result.created_by' => $this->created_by,
            'test_result.updated_by' => $this->updated_by,
            'test_result.expire_at' => $this->expire_at,
            'course.id' => $this->course_id,
            'faculty.id' => $this->faculty_id
//            'test_result.test_id' => $this->test_id,
//            'test_result.user_id' => $this->user_id,
//            'test_result.duration' => $this->duration,
//            'test_result.tests_count' => $this->tests_count,
//            'test_result.correct_answers' => $this->correct_answers,
        ]);

        if ($this->price == 2) {
            $query->andWhere(['test_result.price' => 0]);
        }

        if ($this->price == 1) {
            $query->andWhere(['>', 'test_result.price', 0]);
        }

        // Join with related tables
        $query
            ->andFilterWhere(['like', 'user.id', $this->user_id])
            ->andFilterWhere(['like', 'test.name', $this->test_id])
            ->andFilterWhere(['like', 'user.full_name', $this->userFullName])
            ->andFilterWhere(['like', 'test_result.duration', $this->duration])
            ->andFilterWhere(['like', 'test_result.tests_count', $this->tests_count])
            ->andFilterWhere(['like', 'test_result.correct_answers', $this->correct_answers]);

        return $dataProvider;
    }
}
