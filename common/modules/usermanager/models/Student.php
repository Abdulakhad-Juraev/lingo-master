<?php

namespace common\modules\usermanager\models;


use common\modules\regionmanager\models\District;
use common\modules\regionmanager\models\Region;
use common\modules\university\models\Course;
use common\modules\university\models\Direction;
use common\modules\university\models\Faculty;
use common\modules\university\models\Language;
use soft\helpers\ArrayHelper;
use yii\db\ActiveQuery;

class Student extends User
{


    /**
     * @property string $created_at
     **/
    const SCENARIO_CREATE_BY_STUDENT = 'create_by_student';

    /**
     * Admin tomonidan filiallardagi xodim (menejer va konsultantlar)ni
     * tahrirlashda kerak bo'ladi
     */
    const SCENARIO_UPDATE_STUDENT = 'update_by_student';

    public function rules()
    {
        return [

            [['username'], 'trim'],
            ['username', 'unique', 'message' => 'Ushbu jshshir  avvalroq band qilingan.'],
            ['username', 'match', 'pattern' => '/^[0-9]{14}$/'],
            [['username'], 'string', 'length' => 14],
            [['username', 'full_name', 'faculty_id', 'direction_id', 'language_id', 'type_id', 'course_id', 'educational_type', 'educational_form'], 'required'],
            [['username', 'full_name', 'passport_series', 'born_date'], 'string', 'max' => 255],
            [['region_id', 'district_id', 'passport_number', 'passport_type', 'faculty_id', 'department_id', 'language_id', 'direction_id', 'type_id', 'jshshir', 'course_id', 'educational_type', 'educational_form'], 'integer'],
            ['password', 'string', 'min' => 5],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['password', 'required', 'on' => [self::SCENARIO_CREATE_BY_STUDENT],],
            [['created_at'], 'integer']
        ];
    }

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE_BY_STUDENT] = ['full_name', 'username', 'password', 'status', 'faculty_id', 'region_id', 'district_id', 'language_id', 'direction_id', 'type_id', 'born_date', 'course_id', 'educational_type', 'educational_form'];
        $scenarios[self::SCENARIO_UPDATE_STUDENT] = ['full_name', 'username', 'password', 'status', 'faculty_id', 'region_id', 'district_id', 'language_id', 'direction_id', 'type_id', 'born_date', 'course_id', 'educational_type', 'educational_form'];
        return $scenarios;
    }

    /**
     * @return ActiveQuery
     */
    public function getFaculty(): ActiveQuery
    {
        return $this->hasOne(Faculty::className(), ['id' => 'faculty_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDirection(): ActiveQuery
    {
        return $this->hasOne(Direction::className(), ['id' => 'direction_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLanguage(): ActiveQuery
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }


    /**
     * @return ActiveQuery
     */
    public function getDistrict(): ActiveQuery
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRegion(): ActiveQuery
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCourse(): ActiveQuery
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }


}