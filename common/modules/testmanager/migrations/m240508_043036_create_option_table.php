<?php
namespace common\modules\testmanager\migrations;

use yii\db\Migration;


/**
* Handles the creation of table `{{%option}}`.
*/

class m240508_043036_create_option_table extends Migration
{

    public $tableName = '{{%option}}';

    public function safeUp()
    {
        $this->createTable('{{%option}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'text' => $this->text(),
            'question_id' => $this->bigInteger()->unsigned(),
            'is_answer' => $this->tinyInteger(),
            'created_at' => $this->bigInteger(),
            'updated_at' => $this->bigInteger(),
            'user_id' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('option_question_id', '{{%option}}', 'question_id', '{{%question}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('option_user_id', '{{%option}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('option_updated_by', '{{%option}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('option_question_id', '{{%option}}');
        $this->dropForeignKey('option_user_id', '{{%option}}');
        $this->dropForeignKey('option_updated_by', '{{%option}}');
        $this->dropTable('{{%option}}');
    }

}
