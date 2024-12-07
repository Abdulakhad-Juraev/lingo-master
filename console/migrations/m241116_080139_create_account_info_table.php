<?php

use soft\db\Migration;


/**
 * Handles the creation of table `{{%account_info}}`.
 */
class m241116_080139_create_account_info_table extends Migration
{
    public $tableName = '{{%account_info}}';

    public $blameable = true;

    public $timestamp = true;

    public $status = true;

    public $multilingiualAttributes = ['title'];

    public $foreignKeys = [
        [
            'columns' => 'account_info_type_id',
            'refTable' => 'account_info_type',
            'refColumns' => 'id',
            'delete' => 'CASCADE'
        ],
    ];

    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'account_info_type_id' => $this->integer(),
        ];
    }
}
