<?php

use soft\db\Migration;

/**
 * Handles the creation of table `{{%tariff_options}}`.
 */
class m241116_092346_create_tariff_table extends Migration
{
    public $tableName = '{{%tariff}}';

    public $blameable = true;

    public $timestamp = true;

    public $status = true;

    public $multilingiualAttributes = ['title','description'];

    public $foreignKeys = [
        [
            'columns' => 'user_id',
            'refTable' => 'user',
            'refColumns' => 'id',
            'delete' => 'CASCADE'
        ],
    ];
    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->string(),
            'price' => $this->double(),
            'price_month' => $this->tinyInteger(),
            'most_popular' => $this->tinyInteger(),
            'user_id' => $this->integer()
        ];
    }
}
