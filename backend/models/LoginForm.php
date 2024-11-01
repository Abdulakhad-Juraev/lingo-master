<?php

namespace backend\models;


use common\models\User;
use soft\helpers\PhoneHelper;
use Yii;
use yii\base\Model;

/**
 * Login form
 *
 * @property-read null|\common\models\User $user
 */
class LoginForm extends Model
{
    public $username;

    public $password;
    public $rememberMe = true;

    private $_user;
    const PHONE_PATTERN = '/[9][9][8]\d{9}/';


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            ['username', 'string'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Tel raqam',
            'password' => 'Parol',
            'rememberMe' => 'Eslab qolish'
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
                $this->addError($attribute, Yii::t('app','login_parol_error_message'));
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
        if ($this->_user === null) {
            $this->_user = User::findOne(['username' => $this->getClearPhone()]);
        }

        return $this->_user;
    }


    /**
     * Telefon raqamni qo'shimcha belgilardan tozalash,
     * masalan: +998(99) 123-45-67 => 998991234567
     * @return string cleared phone number
     */
    public function getClearPhone()
    {
        return strtr($this->username, [
            ' ' => '',
            '-' => '',
            '+' => '',
            '(' => '',
            ')' => '',
        ]);
    }
}