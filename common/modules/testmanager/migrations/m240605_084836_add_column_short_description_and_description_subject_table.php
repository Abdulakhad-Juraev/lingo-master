<?php

namespace common\modules\testmanager\migrations;


use yii\db\Migration;

/**
 * Class m240605_084836_add_column_info_and_description_table
 */
class m240605_084836_add_column_short_description_and_description_subject_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%subject_lang}}', 'short_description', $this->string());
        $this->addColumn('{{%subject_lang}}', 'description', $this->text());
        $this->addColumn('{{%subject}}', 'photo', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%subject_lang}}', 'short_description');
        $this->dropColumn('{{%subject_lang}}', 'description');
        $this->dropColumn('{{%subject}}', 'photo');

    }
}
