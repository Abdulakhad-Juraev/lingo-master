<?php

use soft\db\Migration;


/**
 * Handles the creation of table `{{%user_subscription}}`.
 */
class m241118_053537_create_user_subscription_table extends Migration
{
    public $tableName = '{{%user_subscription}}';

    public $blameable = true;

    public $timestamp = true;

    public $status = true;

    public $foreignKeys = [
        [
            'columns' => 'tariff_id',
            'refTable' => 'tariff',
            'refColumns' => 'id',
            'delete' => 'CASCADE'
        ],
        [
            'columns' => 'user_id',
            'refTable' => 'user',
            'refColumns' => 'id',
            'delete' => 'CASCADE'
        ]
    ];

    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'tariff_id' => $this->integer()->notNull(),
            'start_date' => $this->bigInteger()->notNull(),
            'end_date' => $this->bigInteger()->notNull(),
        ];
    }
}
