<?php

namespace common\modules\toeflExam\migrations;

use soft\db\Migration;


/**
 * Handles the creation of table `{{%toefl_options}}`.
 */
class m240627_100600_create_toefl_options_table extends Migration
{

    public $blameable = true;
    public $timestamp = true;
    public $tableName = '{{%toefl_option}}';
    public $status = true;
    public $foreignKeys = [
        [
            'columns' => 'toefl_question_id',
            'refTable' => 'toefl_question',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ];

    public function attributes(): array
    {
        return [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'text' => $this->string(),
            'is_correct' => $this->boolean(),
            'toefl_question_id' => $this->bigInteger()->unsigned(),
        ];
    }
}
