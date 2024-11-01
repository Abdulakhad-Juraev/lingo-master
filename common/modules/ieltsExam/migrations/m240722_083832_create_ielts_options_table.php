<?php

namespace common\modules\ieltsExam\migrations;

use soft\db\Migration;

/**
 * Handles the creation of table `{{%ielts_options}}`.
 */
class m240722_083832_create_ielts_options_table extends Migration
{
    public $tableName = '{{%ielts_options}}';
    public $blameable = true;
    public $timestamp = true;

    public $foreignKeys = [
        [
            'columns' => 'question_id',
            'refTable' => 'ielts_questions',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ]
    ];

    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'text' => $this->text(),
            'question_id' => $this->integer(),
            'is_correct' => $this->boolean(),
        ];
    }

}
