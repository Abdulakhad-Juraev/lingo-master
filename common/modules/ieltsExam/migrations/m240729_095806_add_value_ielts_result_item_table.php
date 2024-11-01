<?php

namespace common\modules\ieltsExam\migrations;

use yii\db\Migration;

/**
 * Class m240729_095806_add_value_ielts_result_item_table
 */
class m240729_095806_add_value_ielts_result_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ielts_result_item', 'value', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('ielts_result_item', 'value');
    }
}
