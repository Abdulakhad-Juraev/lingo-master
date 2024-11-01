<?php

namespace  common\modules\ieltsExam\migrations;

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%ielts_questions}}`.
 */
class m240729_105859_add_section_column_to_ielts_questions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ielts_questions}}', 'section', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ielts_questions}}', 'section');
    }
}
