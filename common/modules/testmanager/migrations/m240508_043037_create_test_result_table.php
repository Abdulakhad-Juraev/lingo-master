<?php

namespace common\modules\testmanager\migrations;

use soft\db\Migration;

/**
 * Handles the creation of table `{{%test_result}}`.
 */
class m240508_043037_create_test_result_table extends Migration
{

    public $tableName = '{{%test_result}}';

    public $blameable = true;

    public $timestamp = true;

    public $status = true;
    public $foreignKeys = [
        [
            'columns' => 'user_id',
            'refTable' => 'user',
            'delete' => 'RESTRICT',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'test_id',
            'refTable' => 'user',
            'delete' => 'RESTRICT',
            'update' => 'CASCADE',
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'duration' => $this->smallInteger(),
            'test_id' => $this->integer(),
            'score' => $this->integer(),
            'started_at' => $this->integer(),
            'tests_count' => $this->smallInteger(),
            'correct_answers' => $this->smallInteger(),
            'expire_at' => $this->integer(),
            'price' => $this->integer(),
            'finished_at' => $this->integer(),
        ];
    }

}
