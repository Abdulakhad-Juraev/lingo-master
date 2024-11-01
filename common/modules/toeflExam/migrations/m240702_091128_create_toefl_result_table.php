<?php

namespace common\modules\toeflExam\migrations;


use soft\db\Migration;

/**
 * Handles the creation of table `{{%toefl_result}}`.
 */
class m240702_091128_create_toefl_result_table extends Migration
{
    public $blameable = true;
    public $timestamp = true;
    public $tableName = '{{%toefl_result}}';
    public $status = true;
    public $foreignKeys = [
        [
            'columns' => 'user_id',
            'refTable' => 'user',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'exam_id',
            'refTable' => 'english_exam',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ];

    public function attributes(): array
    {
        return [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'user_id' => $this->integer(),
            'exam_id' => $this->integer(),
            'started_at' => $this->integer(),
            'started_at_listening' => $this->integer(),
            'started_at_reading' => $this->integer(),
            'started_at_writing' => $this->integer(),
            'expire_at' => $this->integer(),
            'expire_at_listening' => $this->integer(),
            'expire_at_reading' => $this->integer(),
            'expire_at_writing' => $this->integer(),
            'reading_duration' => $this->integer(),
            'writing_duration' => $this->integer(),
            'listening_duration' => $this->integer(),
            'correct_answers_listening' => $this->integer(),
            'correct_answers_reading' => $this->integer(),
            'correct_answers_writing' => $this->integer(),
            'price' => $this->integer(),
            'finished_at' => $this->integer(),
            'finished_at_listening' => $this->integer(),
            'finished_at_reading' => $this->integer(),
            'finished_at_writing' => $this->integer(),
            'step' => $this->tinyInteger(),
        ];
    }

}
