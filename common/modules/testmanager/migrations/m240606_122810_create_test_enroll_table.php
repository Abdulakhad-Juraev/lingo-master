<?php

namespace common\modules\testmanager\migrations;


use soft\db\Migration;

/**
 * Handles the creation of table `{{%test_enroll}}`.
 */
class m240606_122810_create_test_enroll_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    public $blameable = true;

    public $timestamp = true;
    public $tableName = '{{%test_enroll}}';
    public $foreignKeys = [
        [
            'columns' => 'user_id',
            'refTable' => 'user',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'test_id',
            'refTable' => 'test',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ];

    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'test_id' => $this->integer(),
            'user_id' => $this->integer(),
            'payment_type_id' => $this->tinyInteger(),
            'price' => $this->integer(),
            'count' => $this->tinyInteger()
        ];
    }
}
