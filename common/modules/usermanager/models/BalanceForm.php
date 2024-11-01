<?php

namespace common\modules\usermanager\models;

use Yii;
use yii\base\Model;
use common\models\Settings;

class BalanceForm extends Model
{
    protected int $_id;
    public ?int $user_id = null;
    public int $money = 0;
    public ?string $password = null;
    public string $comment = '';

    public function rules(): array
    {
        return [
            [['user_id', 'money', 'password'], 'required'],
            [['user_id', 'money'], 'integer'],
            [['password'], 'string', 'skipOnEmpty' => false, 'skipOnError' => false],
            [['password'], 'validatePassword', 'skipOnEmpty' => false, 'skipOnError' => false],
            ['money', 'compare', 'compareValue' => 0, 'operator' => '!='],
            [['user_id'], 'exist', 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function validatePassword($attribute, $params, $validator): void
    {
        $password = (string)Settings::get(Settings::BALANCE_PASSWORD);

        if ($this->password !== $password) {
            $this->addError('password', Yii::t('app', 'Password-Error'));
        }
    }

    /**
     * @throws \yii\web\ServerErrorHttpException
     */
    public function pay(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        $user = User::findOne($this->user_id);
        if ($this->_id = $user->addBalance($this->money, $this->money > 0 ? Balance::REASON_FILL_BALANCE_BY_ADMIN : Balance::REASON_REDUCE_BALANCE_BY_ADMIN)) {
            return true;
        }
        return false;
    }

    public function attributeLabels(): array
    {
        return [
            'user_id' => Yii::t('app', 'Client'),
            'money' => Yii::t('app', 'Amount of money'),
            'password' => Yii::t('app', 'Password'),
        ];
    }

    public function getId(): int
    {
        return $this->_id;
    }
}