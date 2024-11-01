<?php

namespace common\modules\toeflExam\migrations;


use soft\db\Migration;


/**
 * Handles the creation of table `{{%toefl_question}}`.
 */
class m240627_093946_create_toefl_questions_table extends Migration
{
    public $blameable = true;
    public $timestamp = true;
    public $tableName = '{{%toefl_question}}';
    public $status = true;
    public $foreignKeys = [
        [
            'columns' => 'reading_group_id',
            'refTable' => 'toefl_reading_group',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'listening_group_id',
            'refTable' => 'toefl_listening_group',
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

    public function attributes(): array
    {
        return [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'value' => $this->text(),
            'type_id' => $this->tinyInteger(),
            'test_type_id' => $this->tinyInteger(),
            'reading_group_id' => $this->bigInteger()->unsigned(),
            'listening_group_id' => $this->bigInteger()->unsigned(),
            'exam_id' => $this->integer(),
        ];
    }
}
