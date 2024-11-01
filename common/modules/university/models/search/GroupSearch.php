<?php

namespace common\modules\university\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\university\models\Group;

class GroupSearch extends Group
{

    public function rules()
    {
        return [
            ['name', 'safe'],
            [['id', 'direction_id','language_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at','course_id'], 'integer'],
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
            $query = Group::find()->joinWith('translation');
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
            'direction_id' => $this->direction_id,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'language_id' => $this->language_id,
            'course_id' => $this->course_id,
        ]);
        $query->andFilterWhere(['like', 'group_lang.name', $this->name]);
        return $dataProvider;
    }
}
