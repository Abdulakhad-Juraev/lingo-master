<?php
namespace common\modules\testmanager\migrations;

use yii\db\Migration;


/**
 * Handles the creation of table `{{%question}}`.
 */
class m240508_043035_create_question_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%question}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'title' => $this->text(),
            'test_id' => $this->integer(),
            'status' => $this->tinyInteger(),
            'created_at' => $this->bigInteger(),
            'updated_at' => $this->bigInteger(),
            'user_id' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('question_test_id', '{{%question}}', 'test_id', '{{%test}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('question_user_id', '{{%question}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('question_updated_by', '{{%question}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('question_test_id', '{{%question}}');
        $this->dropForeignKey('question_user_id', '{{%question}}');
        $this->dropForeignKey('question_updated_by', '{{%question}}');
        $this->dropTable('{{%question}}');
    }

}
