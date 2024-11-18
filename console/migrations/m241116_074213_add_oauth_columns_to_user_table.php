<?php

use soft\db\Migration;


/**
 * Handles the creation of table `{{%oauth_user}}`.
 */
class m241116_074213_add_oauth_columns_to_user_table extends Migration
{
    public $tableName = '{{%user}}';

    /** * {@inheritdoc} */
    public function safeUp()
    {
        $this->addColumn('user', 'user_id', $this->string()->notNull());
        $this->addColumn('user', 'name', $this->string());
        $this->addColumn('user', 'auth_provider', $this->string()->notNull());
        $this->addColumn('user', 'provider_id', $this->string()->unique()->notNull());
        $this->addColumn('user', 'profile_picture_url', $this->text());
        $this->addColumn('user', 'phone_number', $this->string());
        $this->addColumn('user', 'access_token', $this->text());
        $this->addColumn('user', 'refresh_token', $this->text());
        $this->addColumn('user', 'locale', $this->string());
    }

    /** * {@inheritdoc} */
    public function safeDown()
    {
        $this->dropColumn('user', 'user_id');
        $this->dropColumn('user', 'name');
        $this->dropColumn('user', 'auth_provider');
        $this->dropColumn('user', 'provider_id');
        $this->dropColumn('user', 'profile_picture_url');
        $this->dropColumn('user', 'phone_number');
        $this->dropColumn('user', 'access_token');
        $this->dropColumn('user', 'refresh_token');
        $this->dropColumn('user', 'locale');
    }
}
