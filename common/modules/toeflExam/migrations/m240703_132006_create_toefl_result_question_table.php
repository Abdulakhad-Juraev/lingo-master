<?php

namespace common\modules\toeflExam\migrations;


use soft\db\Migration;

/**
 * Handles the creation of table `{{%toefl_result_question}}`.
 */
class m240703_132006_create_toefl_result_question_table extends Migration
{
    public $blameable = true;
    public $timestamp = true;
    public $tableName = '{{%toefl_result_question}}';
    public $status = true;
    public $foreignKeys = [
        [
            'columns' => 'result_id',
            'refTable' => 'toefl_result',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],

        [
            'columns' => 'l_group_id',
            'refTable' => 'toefl_listening_group',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'r_group_id',
            'refTable' => 'toefl_reading_group',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'user_id',
            'refTable' => 'user',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ];

    public function attributes(): array
    {
        return [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'result_id' => $this->bigInteger()->unsigned(),
            'l_group_id' => $this->bigInteger()->unsigned(),
            'r_group_id' => $this->bigInteger()->unsigned(),
            'user_id' => $this->integer(),
            'is_used' => $this->tinyInteger()
        ];
    }
}
