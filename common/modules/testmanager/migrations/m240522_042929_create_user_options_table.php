<?php

namespace common\modules\testmanager\migrations;

use soft\db\Migration;

/**
 * Handles the creation of table `{{%user_options}}`.
 */
class m240522_042929_create_user_options_table extends Migration
{

    public $tableName = '{{%user_options}}';

    public $foreignKeys = [
        [
            'columns' => 'question_id',
            'refTable' => 'question',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'option_id',
            'refTable' => 'option',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'result_id',
            'refTable' => 'test_result',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function attributes(): array
    {
        return [
            'id' => $this->primaryKey(),
            'question_id' => $this->bigInteger()->unsigned(),
            'result_id' => $this->integer(),
            'option_id' =>$this->bigInteger()->unsigned(),
        ];
    }

}
