<?php

use soft\db\Migration;


/**
 * Handles the creation of table `{{%temp_user}}`.
 */
class m241101_104859_create_temp_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%temp_user}}');
    }

    public $tableName = '{{%temp_user}}';

    public $blameable = false;

    public $timestamp = true;

    public $status = false;

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'phone' => $this->string(),
            'code' => $this->integer(),
            'expire_at' => $this->integer(),
            'is_verified' => $this->boolean()->defaultValue(false),
            'is_registered' => $this->boolean()->defaultValue(false),
        ];
    }

}
