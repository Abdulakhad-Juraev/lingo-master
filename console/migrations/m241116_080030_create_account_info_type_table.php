<?php

use soft\db\Migration;


/**
 * Handles the creation of table `{{%account_info_type}}`.
 */
class m241116_080030_create_account_info_type_table extends Migration
{

    public $tableName = '{{%account_info_type}}';

    public $blameable = true;

    public $timestamp = true;

    public $status = true;

    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'title' => $this->string()
        ];
    }
}
