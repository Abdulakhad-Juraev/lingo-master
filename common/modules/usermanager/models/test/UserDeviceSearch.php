<?php


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserDeviceSearch extends UserDevice
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['device_name', 'device_id', 'firebase_token', 'token'], 'string'],
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
            $query = UserDevice::find()->joinWith('translation');
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
            'device_name' => $this->device_name,
            'device_id' => $this->device_id,
            'firebase_token' => $this->firebase_token,
            'token' => $this->token,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
