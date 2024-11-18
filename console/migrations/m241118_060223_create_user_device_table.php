<?php

use soft\db\Migration;


/**
 * Handles the creation of table `{{%user_device}}`.
 */
class m241118_060223_create_user_device_table extends Migration
{
    public $tableName = '{{%user_device}}';

    public $blameable = true;

    public $timestamp = true;

    public $status = true;

    public $foreignKeys = [
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
            'device_name' => $this->string()->notNull(),
            'device_id' => $this->string()->notNull(),
            'firebase_token' => $this->string(),
            'token' => $this->string(),
        ];
    }
}
