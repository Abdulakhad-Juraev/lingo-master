<?php

namespace common\modules\ieltsExam\migrations;

use soft\db\Migration;

/**
 * Handles the creation of table `{{%ielts_result}}`.
 */
class m240722_084427_create_ielts_result_table extends Migration
{
    public $tableName = '{{%ielts_result}}';
    public $blameable = true;
    public $timestamp = true;
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
        ]
    ];


    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'exam_id' => $this->integer(),
            'started_at' => $this->integer(),
            'started_at_listening' => $this->integer(),
            'started_at_reading' => $this->integer(),
            'started_at_writing' => $this->integer(),
            'started_at_speaking' => $this->integer(),
            'expired_at' => $this->integer(),
            'expired_at_listening' => $this->integer(),
            'expired_at_reading' => $this->integer(),
            'expired_at_writing' => $this->integer(),
            'expired_at_speaking' => $this->integer(),

            'listening_duration' => $this->integer(),
            'reading_duration' => $this->integer(),
            'writing_duration' => $this->integer(),
            'speaking_duration' => $this->integer(),
            'correct_answers_listening' => $this->integer(),
            'correct_answers_reading' => $this->integer(),

            'listening_score' => $this->float()->comment('7.5'),
            'reading_score' => $this->float()->comment('7.5'),
            'writing_score' => $this->float()->comment('7.5'),
            'speaking_score' => $this->float()->comment('7.5'),
            'step' => $this->integer()->comment('listening/reading/writing/speaking'),
            'finished_at' => $this->integer(),
        ];
    }

}
