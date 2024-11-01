<?php

namespace common\modules\usermanager\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\usermanager\models\UserDevice;

class UserDeviceSearch extends UserDevice
{

    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['device_name', 'device_id', 'firebase_token', 'token'], 'safe'],
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
            $query = UserDevice::find();
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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'device_name', $this->device_name])
            ->andFilterWhere(['like', 'device_id', $this->device_id])
            ->andFilterWhere(['like', 'firebase_token', $this->firebase_token])
            ->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
