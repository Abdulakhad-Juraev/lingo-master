<?php
namespace common\modules\toeflExam\migrations;
use soft\db\Migration;

/**
 * Handles the creation of table `{{%toefl_result_item}}`.
 */
class m240702_095010_create_toefl_result_item_table extends Migration
{
    public $blameable = true;
    public $timestamp = true;
    public $tableName = '{{%toefl_result_item}}';
    public $status = true;
    public $foreignKeys = [
        [
            'columns' => 'result_id',
            'refTable' => 'toefl_result',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'question_id',
            'refTable' => 'toefl_question',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'user_answer_id',
            'refTable' => 'toefl_option',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'original_answer_id',
            'refTable' => 'toefl_option',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'listening_group_id',
            'refTable' => 'toefl_listening_group',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'reading_group_id',
            'refTable' => 'toefl_reading_group',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ];
    public function attributes(): array
    {
        return [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'result_id' => $this->bigInteger()->unsigned(),
            'question_id' => $this->bigInteger()->unsigned(),
            'user_answer_id' => $this->bigInteger()->unsigned(),
            'original_answer_id' => $this->bigInteger()->unsigned(),
            'is_correct' => $this->boolean(),
            'listening_group_id' => $this->bigInteger()->unsigned(),
            'reading_group_id' => $this->bigInteger()->unsigned(),
        ];
    }
}
