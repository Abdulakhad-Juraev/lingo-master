<?php

use soft\db\Migration;


/**
 * Handles the creation of table `{{%tariff_options}}`.
 */
class m241118_052930_create_tariff_options_table extends Migration
{
    public $tableName = '{{%tariff_options}}';

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
            'columns' => 'tariff_id',
            'refTable' => 'tariff',
            'refColumns' => 'id',
            'delete' => 'CASCADE'
        ],
    ];
    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'free' => $this->boolean(),
            'premium' => $this->boolean(),
            'tariff_id' => $this->integer(),
            'user_id' => $this->integer()
        ];
    }
}
