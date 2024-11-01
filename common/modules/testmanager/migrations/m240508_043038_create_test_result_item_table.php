<?php
namespace common\modules\testmanager\migrations;


use yii\db\Migration;


/**
 * Handles the creation of table `{{%test_result_item}}`.
 */
class m240508_043038_create_test_result_item_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%test_result_item}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'test_result_id' => $this->integer(),
            'question_id' => $this->bigInteger()->unsigned(),
            'user_answer_id' => $this->bigInteger()->unsigned(),
            'original_answer_id' => $this->bigInteger()->unsigned(),
            'is_correct' => $this->tinyInteger(),
            'is_checked' => $this->boolean()->defaultValue(false),

        ]);
        $this->addForeignKey('test_result_item_test_result_id', '{{%test_result_item}}', 'test_result_id', '{{%test_result}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('test_result_item_question_id', '{{%test_result_item}}', 'question_id', '{{%question}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('test_result_item_user_answer_id', '{{%test_result_item}}', 'user_answer_id', '{{%option}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('test_result_item_original_answer_id', '{{%test_result_item}}', 'original_answer_id', '{{%option}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('test_result_item_test_result_id', '{{%test_result_item}}');
        $this->dropForeignKey('test_result_item_question_id', '{{%test_result_item}}');
        $this->dropForeignKey('test_result_item_user_answer_id', '{{%test_result_item}}');
        $this->dropForeignKey('test_result_item_original_answer_id', '{{%test_result_item}}');
        $this->dropTable('{{%test_result_item}}');
    }

}
