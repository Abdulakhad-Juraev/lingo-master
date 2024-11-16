<?php

use soft\db\Migration;

/**
 * Handles the creation of table `{{%tariff_options}}`.
 */
class m241116_092346_create_tariff_options_table extends Migration
{
    public $tableName = 'tariff_options';

    public $blameable = true;

    public $timestamp = true;

    public $status = true;

    public $multilingiualAttributes = ['title'];


    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'type_id' => $this->integer(),
            'user_id' => $this->integer()
        ];
    }
}
