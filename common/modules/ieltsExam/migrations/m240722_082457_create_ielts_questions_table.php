<?php

namespace common\modules\ieltsExam\migrations;

use soft\db\Migration;

/**
 * Handles the creation of table `{{%ielts_questions}}`.
 */
class m240722_082457_create_ielts_questions_table extends Migration
{
    public $tableName = "{{%ielts_questions}}";
    public $blameable = true;
    public $timestamp = true;

    public $foreignKeys = [
        [
            'columns' => 'exam_id',
            'refTable' => '{{%english_exam}}',
            'delete' => 'CASCADE',
            'onUpdate' => 'CASCADE'
        ],
        [
            'columns' => 'question_group_id',
            'refTable' => '{{%ielts_question_group}}',
            'delete' => 'CASCADE',
            'onUpdate' => 'CASCADE'
        ],
    ];

    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'value' => $this->string(),
            'question_group_id' => $this->integer(),
            'exam_id' => $this->integer(),
            'type_id' => $this->integer(),
            'info' => $this->string()
        ];
    }

}
