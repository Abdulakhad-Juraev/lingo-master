<?php

namespace common\modules\usermanager\models;

use soft\helpers\PhoneHelper;
use yii\base\Model;

class TeacherForm extends Model
{


    /**
     * @property string $firstname
     * @property string $lastname
     * @property string $middle_name
     * @property string $phone
     * @property integer $department_id
     * @property integer $faculty_id
     * @property string $born_date
     * @property integer $region_id
     * @property integer $district_id
     * @property string $password
     * @property integer $passport_number
     * @property string $passport_series
     * @property string $passport_type
     */
    public $firstname;
    public $phone;
    public $lastname;
    public $middle_name;
    public $department_id;
    public $faculty_id;
    public $born_date;
    public $region_id;
    public $district_id;
    public $username;
    public $password;
    public const SCENARIO_CREATE = 'create';
    const PHONE_PATTERN = '/[9][9][8]\d{9}/';


    public function rules()
    {
        return [
            [['firstname', 'lastname', 'middle_name'], 'string'],
            ['username', 'trim'],
            ['password', 'required', 'on' => [self::SCENARIO_CREATE],],
            ['username', 'checkUsername'],
            [['department_id', 'faculty_id', 'region_id', 'district_id'], 'integer'],
            ['born_date', 'safe']
        ];
    }



    public function checkPhone(): bool
    {
        $phone = $this->getClearPhone();


        if (!empty($phone)) {
            if (!preg_match(static::PHONE_PATTERN, $phone)) {
                $this->addError('phone', t('Incorrect phone number'));
                return false;
            }
            $user = User::findOne(['username' => $phone]);
            if ($user == null) {
                return true;
            } else {
                $this->addError('phone', 'Ushbu telefon raqam avvalroq band qilingan');
            }
            return true;
        }
        return false;
    }

    public function checkUsername(): bool
    {
        $user = User::findOne(['username' => $this->username]);
        if ($user == null) {
            return true;
        } else {
            $this->addError('phone', 'Ushbu username avvalroq band qilingan');
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Telefon raqam',
            'firstname' => 'Ism',
            'lastname' => 'Familiya',
            'middle_name' => 'Otasining ismi',
            'username' => 'Login',
            'password' => 'Parol',
            'department_id' => 'Kafedra',
            'faculty_id' => 'Fakultet',
            'region_id' => 'Viloyat',
            'district_id' => 'Tuman yoki shahar',
            'born_date' => 'Tug\'ilgan sana',
        ];
    }
}