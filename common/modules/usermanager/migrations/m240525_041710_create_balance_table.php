<?php

namespace common\modules\usermanager\migrations;

use soft\db\Migration;

/**
 * Handles the creation of table `{{%balance}}`.
 */
class m240525_041710_create_balance_table extends Migration
{

    public $tableName = '{{%balance}}';

    public $blameable = true;

    public $timestamp = true;
    /**
     * {@inheritdoc}
     */
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
    public function attributes(): array
    {
        return [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'type' => $this->tinyInteger(),
            'value' => $this->integer(),
            'total' => $this->integer(),
            'reason' => $this->tinyInteger(),
            'comment' => $this->text(),
            'test_id' => $this->integer(),
        ];
    }

}
