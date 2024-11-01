<?php

namespace common\modules\ieltsExam\migrations;


use soft\db\Migration;

/**
 * Handles the creation of table `{{%ielts_question_group_result}}`.
 */
class m240726_090845_create_ielts_question_group_result_table extends Migration
{
    public $blameable = true;
    public $timestamp = true;
    public $tableName = '{{%ielts_question_group_result}}';
    public $status = true;
    public $foreignKeys = [
        [
            'columns' => 'result_id',
            'refTable' => 'ielts_result',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],

        [
            'columns' => 'group_id',
            'refTable' => 'ielts_question_group',
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
            'result_id' => $this->integer(),
            'group_id' => $this->integer(),
            'user_id' => $this->integer(),
            'is_used' => $this->tinyInteger(),
            'type_id' => $this->integer(),
        ];
    }
}
