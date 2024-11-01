<?php

namespace common\modules\toeflExam\migrations;

use soft\db\Migration;


/**
 * Handles the creation of table `{{%toefl_reading_group}}`.
 */
class m240627_093831_create_toefl_reading_group_table extends Migration
{
    public $blameable = true;
    public $timestamp = true;
    public $tableName = '{{%toefl_reading_group}}';
    public $status = true;
    public $foreignKeys = [
        [
            'columns' => 'exam_id',
            'refTable' => 'english_exam',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ]
    ];

    public function attributes(): array
    {
        return [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'text' => $this->text(),
            'exam_id' => $this->integer()
        ];
    }
}
