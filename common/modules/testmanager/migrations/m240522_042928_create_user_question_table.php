<?php
namespace common\modules\testmanager\migrations;


use soft\db\Migration;

/**
 * Handles the creation of table `{{%user_question}}`.
 */
class m240522_042928_create_user_question_table extends Migration
{

    public $tableName = '{{%user_question}}';

    public $foreignKeys = [
        [
            'columns' => 'question_id',
            'refTable' => 'question',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'result_id',
            'refTable' => 'test_result',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'question_id' => $this->bigInteger()->unsigned(),
            'result_id' => $this->integer(),
        ];
    }

}
