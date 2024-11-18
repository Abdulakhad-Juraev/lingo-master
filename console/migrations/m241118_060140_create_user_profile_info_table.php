<?php

use soft\db\Migration;

/**
 * Handles the creation of table `{{%user_profile_info}}`.
 */
class m241118_060140_create_user_profile_info_table extends Migration
{


    public $tableName = '{{%user_profile_info}}';

    public $blameable = true;

    public $timestamp = true;

    public $status = true;

    public $foreignKeys = [
        [
            'columns' => 'user_id',
            'refTable' => 'user',
            'refColumns' => 'id',
            'delete' => 'CASCADE'
        ],
        [
            'columns' => 'account_info_id',
            'refTable' => 'account_info',
            'refColumns' => 'id',
            'delete' => 'CASCADE'
        ],
        [
            'columns' => 'account_info_type_id',
            'refTable' => 'account_info_type',
            'refColumns' => 'id',
            'delete' => 'CASCADE'
        ]
    ];

    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'account_info_id' => $this->integer()->notNull(),
            'account_info_type_id' => $this->integer()->notNull(),
        ];
    }
}
