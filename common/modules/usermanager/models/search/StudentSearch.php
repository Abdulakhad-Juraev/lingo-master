<?php

namespace common\modules\usermanager\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use common\modules\usermanager\models\Student;

class StudentSearch extends Student
{

    public function rules()
    {
        return [
            [['username', 'full_name', 'created_at'], 'safe',],
            [['region_id', 'district_id', 'passport_number', 'passport_type', 'faculty_id', 'department_id', 'language_id', 'direction_id', 'type_id', 'jshshir', 'course_id', 'educational_type', 'educational_form'], 'integer'],
        ];
    }

    public function search($query = null, $defaultPageSize = 20, $params = null)
    {

        if ($params == null) {
            $params = Yii::$app->request->queryParams;
        }
        if ($query == null) {
            $query = Student::find();
        }

        $dataProvider = new ActiveDataProvider(['query' => $query,
            'pagination' => [
                'defaultPageSize' => $defaultPageSize,
            ],
        ]);

        $this->load($params);


        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->created_at)) {
            $dates = explode(' - ', $this->created_at, 2);
            if (count($dates) == 2) {
                $begin = strtotime($dates[0]);
                $end = strtotime('+1 day', strtotime($dates[1]));
                $query->andFilterWhere(['>=', 'user.created_at', $begin])
                    ->andFilterWhere(['<', 'user.created_at', $end]);
            }
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'faculty_id', $this->faculty_id])
            ->andFilterWhere(['like', 'course_id', $this->course_id])
            ->andFilterWhere(['like', 'jshshir', $this->jshshir]);
        return $dataProvider;
    }
}
