<?php

namespace common\modules\ieltsExam\migrations;

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%ielts_result_item}}`.
 */
class m240726_044338_add_is_used_column_to_ielts_result_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ielts_result_item}}', 'is_used', $this->boolean()->defaultValue(0));
        $this->addColumn('{{%ielts_result_item}}', 'type_id', $this->tinyInteger());
        $this->addColumn('{{%ielts_result_item}}', 'input_type', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ielts_result_item}}', 'is_used');
        $this->dropColumn('{{%ielts_result_item}}', 'type_id');
        $this->dropColumn('{{%ielts_result_item}}', 'input_type');
    }
}
