<?php

namespace common\modules\usermanager\models\search;

use common\modules\usermanager\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{

    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'sex'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'firstname', 'lastname', 'full_name'], 'safe'],
        ];
    }

//    public function scenarios()
//    {
//        // bypass scenarios() implementation in the parent class
//        return Model::scenarios();
//    }

    public function search($query = null, $defaultPageSize = 20, $params = null)
    {

        if ($params == null) {
            $params = Yii::$app->request->queryParams;
        }
        if ($query == null) {
            $query = User::find();
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
            'status' => $this->status,
            'full_name' => $this->full_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sex' => $this->sex,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname]);
        return $dataProvider;
    }
}
