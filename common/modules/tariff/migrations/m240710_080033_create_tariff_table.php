<?php

namespace common\modules\tariff\migrations;


use soft\db\Migration;

/**
 * Handles the creation of table `{{%tariff}}`.
 */
class m240710_080033_create_tariff_table extends Migration
{
    public $tableName = '{{%tariff}}';

    public $blameable = true;

    public $timestamp = true;
    public $status = true;
    public $multilingiualAttributes = ['name', 'short_description'];


    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'short_description' => $this->text(),
            'price' => $this->integer(),
            'old_price' => $this->integer(),
            'duration_number' => $this->integer(),
            'duration_text' => $this->string(),
            'is_recommend' => $this->boolean()->defaultValue(false),
        ];
    }
}
