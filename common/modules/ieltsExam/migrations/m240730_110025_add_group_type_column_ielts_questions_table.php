<?php

namespace common\modules\ieltsExam\migrations;

use yii\db\Migration;

/**
 * Class m240730_110025_add_group_type_column_ielts_questions_table
 */
class m240730_110025_add_group_type_column_ielts_questions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ielts_questions', 'group_type', $this->integer()->comment('Speaking/Writing/Reading/Listening'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('ielts_questions', 'group_type');
    }

}
