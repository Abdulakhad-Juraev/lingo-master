<?php

use yii\db\Migration;


/**
* Handles the creation of table `{{%user_refresh_tokens}}`.
*/

class m240507_043429_create_user_refresh_tokens_table extends Migration
{

    public function safeUp(): void
    {
        $this->createTable('{{%user_refresh_tokens}}', [
            'user_refresh_tokenID' => $this->primaryKey(),
            'urf_userID' => $this->integer()->unsigned()->notNull(),
            'urf_token' => $this->string(1000)->notNull(),
            'urf_ip' => $this->string(50)->notNull(),
            'urf_user_agent' => $this->string(1000)->notNull(),
            'urf_created' => $this->dateTime()->notNull()->comment('UTC'),
        ], 'COMMENT=\'For JWT authentication process\'');

        // Add foreign key constraint if needed
        // $this->addForeignKey('fk_user_refresh_tokens_user', '{{%user_refresh_tokens}}', 'urf_userID', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }
    public function safeDown(): void
    {
        // Drop foreign key if needed
        // $this->dropForeignKey('fk_user_refresh_tokens_user', '{{%user_refresh_tokens}}');

        $this->dropTable('{{%user_refresh_tokens}}');
    }

}
