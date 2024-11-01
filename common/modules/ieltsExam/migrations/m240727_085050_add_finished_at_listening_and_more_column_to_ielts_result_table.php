<?php

namespace common\modules\ieltsExam\migrations;

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%ielts_result}}`.
 */
class m240727_085050_add_finished_at_listening_and_more_column_to_ielts_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ielts_result}}', 'finished_at_listening', $this->integer());
        $this->addColumn('{{%ielts_result}}', 'finished_at_writing', $this->integer());
        $this->addColumn('{{%ielts_result}}', 'finished_at_reading', $this->integer());
        $this->addColumn('{{%ielts_result}}', 'finished_at_speaking', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ielts_result}}', 'finished_at_listening');
        $this->dropColumn('{{%ielts_result}}', 'finished_at_writing');
        $this->dropColumn('{{%ielts_result}}', 'finished_at_reading');
        $this->dropColumn('{{%ielts_result}}', 'finished_at_speaking');
    }
}
