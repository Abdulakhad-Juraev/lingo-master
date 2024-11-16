<?php

use soft\db\Migration;


/**
 * Handles the creation of table `{{%oauth_user}}`.
 */
class m241116_074213_create_oauth_user_table extends Migration
{

    public $tableName = '{{%oauth_user}}';

    public $blameable = true;

    public $timestamp = true;

    public $status = true;

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            'id' => $this->string()->notNull()->primaryKey(),
            'name' => $this->string(),
            'email' => $this->string()->unique(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'auth_provider' => $this->string()->notNull(),
            'provider_id' => $this->string()->unique()->notNull(),
            'profile_picture_url' => $this->text(),
            'phone_number' => $this->string(),
            'access_token' => $this->text(),
            'refresh_token' => $this->text(),
            'locale' => $this->string(),
        ];
    }
}
