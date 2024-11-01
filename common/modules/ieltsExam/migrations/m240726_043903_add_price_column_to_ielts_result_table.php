<?php

namespace common\modules\ieltsExam\migrations;


use yii\db\Migration;

/**
 * Handles adding columns to table `{{%ielts_result}}`.
 */
class m240726_043903_add_price_column_to_ielts_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ielts_result}}', 'price', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ielts_result}}', 'price');
    }
}
