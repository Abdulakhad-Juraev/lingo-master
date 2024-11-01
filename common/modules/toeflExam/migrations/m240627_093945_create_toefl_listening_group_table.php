<?php

namespace common\modules\toeflExam\migrations;

use soft\db\Migration;

/**
 * Handles the creation of table `{{%toefl_listening_group}}`.
 */
class m240627_093945_create_toefl_listening_group_table extends Migration
{
    public $blameable = true;
    public $timestamp = true;
    public $tableName = '{{%toefl_listening_group}}';
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
            'audio' => $this->text(),
            'exam_id' => $this->integer(),
            'type_id' => $this->tinyInteger()
        ];
    }
}
