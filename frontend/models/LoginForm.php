<?php

namespace frontend\models;

use common\models\User;
use soft\base\SoftModel;
use soft\helpers\PhoneHelper;
use Yii;

class LoginForm extends SoftModel
{

    public $username;
    public $password;
    public $rememberMe = true;
    public $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['username', 'match', 'pattern' => '/\+998\(\d{2}\) \d{3}\-\d{2}\-\d{2}/', 'message' => t("Telefon raqam formati not'g'ri")],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Telefon raqam',
            'password' => 'Parol',
            'rememberMe' => 'Eslab qolish',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Telefon raqam yoki parol noto\'g\'ri');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        return $this->_user = User::findByUsername($this->getClearPhone());
    }

    /**
     * Telefon raqamni qo'shimcha belgilardan tozalash,
     * masalan: +998(99) 123-45-67 => 998991234567
     * @return string cleared phone number
     */
    public function getClearPhone()
    {
        return PhoneHelper::fullPhoneNumber($this->username);
    }
}