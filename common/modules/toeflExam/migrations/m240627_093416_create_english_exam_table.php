<?php

namespace common\modules\toeflExam\migrations;


use soft\db\Migration;

/**
 * Handles the creation of table `{{%english_exam}}`.
 */
class m240627_093416_create_english_exam_table extends Migration
{
    public $blameable = true;

    public $timestamp = true;
    public $tableName = '{{%english_exam}}';
    public $status = true;
    public $multilingiualAttributes = ['title', 'short_description'];

    public function attributes(): array
    {
        return [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'short_description' => $this->text(),
            'price' => $this->integer(),
            'number_attempts' => $this->integer(),
            'img' => $this->string(),
            'reading_duration' => $this->integer(),
            'listening_duration' => $this->integer(),
            'writing_duration' => $this->integer(),
            'speaking_duration' => $this->integer(),
            'type' => $this->tinyInteger(),
        ];
    }
}
