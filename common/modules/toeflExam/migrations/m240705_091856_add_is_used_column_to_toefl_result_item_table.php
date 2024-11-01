<?php

namespace common\modules\toeflExam\migrations;

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%toefl_result_item}}`.
 */
class m240705_091856_add_is_used_column_to_toefl_result_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%toefl_result_item}}', 'is_used', $this->boolean()->defaultValue(0));
        $this->addColumn('{{%toefl_result_item}}', 'type_id', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%toefl_result_item}}', 'is_used');
        $this->dropColumn('{{%toefl_result_item}}', 'type_id');
    }
}
