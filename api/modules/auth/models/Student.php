<?php

namespace api\modules\auth\models;


use api\models\Course;
use api\models\Direction;
use api\models\Faculty;
use api\models\Language;
use soft\base\SoftModel;
use yii\db\ActiveRecord;

class Student extends SoftModel
{
    public $faculty_id;
    public $direction_id;
    public $course_id;
    public $language_id;

    public function rules()
    {
        return [
            [['faculty_id', 'direction_id', 'course_id', 'language_id'], 'required'],
            [['faculty_id', 'direction_id', 'course_id', 'language_id'], 'integer'],
            [['faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Faculty::class, 'targetAttribute' => ['faculty_id' => 'id']],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direction::class, 'targetAttribute' => ['direction_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['course_id' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language_id' => 'id']],
        ];
    }
}
