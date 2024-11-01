<?php

namespace common\modules\ieltsExam\migrations;

use soft\db\Migration;


/**
 * Handles the creation of table `{{%ielts_result_item}}`.
 */
class m240722_091553_create_ielts_result_item_table extends Migration
{
    public $tableName = "{{%ielts_result_item}}";
    public $blameable = true;
    public $timestamp = true;

    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'result_id' => $this->integer(),
            'question_id' => $this->integer(),
            'user_answer_id' => $this->integer(),
            'original_answer_id' => $this->integer(),
            'is_correct' => $this->boolean(),
        ];
    }
}
