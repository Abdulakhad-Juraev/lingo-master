<?php

namespace common\modules\usermanager\models;


use common\modules\university\models\Department;
use common\modules\university\models\Faculty;
use yii\db\ActiveQuery;

class Teacher extends User
{
    const SCENARIO_CREATE_BY_TEACHER = 'create_by_teacher';

    /**
     * Admin tomonidan filiallardagi xodim (menejer va konsultantlar)ni
     * tahrirlashda kerak bo'ladi
     */
    const SCENARIO_UPDATE_TEACHER = 'update_by_teacher';

    public function rules()
    {
        return [

            [['username','password'], 'trim'],
            ['username', 'unique', 'message' => 'Ushbu login avvalroq band qilingan.'],
            ['jshshir', 'unique', 'message' => 'Ushbu jshshir avvalroq band qilingan.'],
            ['jshshir','match','pattern' => '/^[0-9]{14}$/'],
            [['jshshir'],'string','length' =>14],
            [['username', 'full_name', 'faculty_id'], 'required',],
            [['username', 'full_name', 'passport_series', 'born_date'], 'string', 'max' => 255],
            [['region_id', 'district_id', 'passport_number', 'passport_type', 'faculty_id', 'department_id', 'group_id', 'direction_id', 'type_id'], 'integer'],
            ['password', 'string', 'min' => 5],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['password', 'required', 'on' => [self::SCENARIO_CREATE_BY_TEACHER],]
        ];
    }

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE_BY_TEACHER] = ['full_name', 'username', 'password', 'status', 'faculty_id', 'region_id', 'district_id', 'department_id', 'group_id', 'direction_id', 'type_id','born_date','jshshir'];
        $scenarios[self::SCENARIO_UPDATE_TEACHER] = ['full_name', 'username', 'password', 'status', 'faculty_id', 'region_id', 'district_id', 'department_id', 'group_id', 'direction_id', 'type_id','born_date','jshshir'];
        return $scenarios;
    }



    public static function getClearPhone($username)
    {
        return strtr($username, [
            ' ' => '',
            '-' => '',
            '+' => '',
            '(' => '',
            ')' => '',
        ]);
    }
}