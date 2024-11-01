<?php
namespace common\modules\toeflExam\migrations;
use soft\db\Migration;
/**
 * Handles the creation of table `{{%toefl_user_option}}`.
 */
class m240705_050558_create_toefl_user_option_table extends Migration
{
    public $tableName = '{{%toefl_user_option}}';

    public $foreignKeys = [
        [
            'columns' => 'question_id',
            'refTable' => 'toefl_question',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'option_id',
            'refTable' => 'toefl_option',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'result_id',
            'refTable' => 'toefl_result',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ];
    /**
     * {@inheritdoc}
     */
    public function attributes(): array
    {
        return [
            'id' => $this->primaryKey(),
            'question_id' => $this->bigInteger()->unsigned(),
            'result_id' => $this->bigInteger()->unsigned(),
            'option_id' =>$this->bigInteger()->unsigned(),
        ];
    }

}
