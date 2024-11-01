<?php

namespace common\modules\ieltsExam\migrations;

use soft\db\Migration;

/**
 * Handles the creation of table `{{%ielts_question_group}}`.
 */
class m240722_065738_create_ielts_question_group_table extends Migration
{
    public $tableName = '{{%ielts_question_group}}';
    public $blameable = true;
    public $timestamp = true;
    public $status = true;

    public $foreignKeys = [
        [
            'columns' => ['exam_id'],
            'refTable' => 'english_exam',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ]
    ];


    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'exam_id' => $this->integer(),
            'content' => $this->string(),
            'audio' => $this->string(),
            'section' => $this->integer(),
            'type_id' => $this->integer(),
        ];
    }

}
