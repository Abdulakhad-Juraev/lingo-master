<?php

namespace common\modules\toeflExam\migrations;

use yii\db\Migration;

/**
 * Class m240708_081616_add_toefl_result_band_score_table
 */
class m240708_081616_add_toefl_result_band_score_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%toefl_result}}', 'listening_score', $this->float()->defaultValue(0));
        $this->addColumn('{{%toefl_result}}', 'reading_score', $this->float()->defaultValue(0));
        $this->addColumn('{{%toefl_result}}', 'writing_score', $this->float()->defaultValue(0));
        $this->addColumn('{{%toefl_result}}', 'cefr_level', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%toefl_result}}', 'listening_score');
        $this->dropColumn('{{%toefl_result}}', 'reading_score');
        $this->dropColumn('{{%toefl_result}}', 'writing_score');
        $this->dropColumn('{{%toefl_result}}', 'cefr_level');
    }
}
