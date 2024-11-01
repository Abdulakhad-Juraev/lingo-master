<?php

namespace common\modules\testmanager\migrations;

use soft\db\Migration;

/**
 * Handles the creation of table `{{%subject}}`.
 */
class m240508_043034_create_test_table extends Migration
{

    public $tableName = '{{%test}}';

    public $blameable = true;

    public $timestamp = true;
    public $foreignKeys = [
        [
            'columns' => 'subject_id',
            'refTable' => 'subject',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'direction_id',
            'refTable' => 'direction',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'course_id',
            'refTable' => 'course',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ] ,
        [
            'columns' => 'semester_id',
            'refTable' => 'semester',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ],
        [
            'columns' => 'language_id',
            'refTable' => 'language',
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'is_free' => $this->tinyInteger(),
            'price' => $this->integer(),
            'started_at' => $this->integer(),
            'finished_at' => $this->integer(),
            'status' => $this->tinyInteger(),
            'duration' => $this->integer(),
            'maximum_score' => $this->integer(),
            'number_tries' => $this->integer(),
            'educational_type' => $this->tinyInteger(),
            'educational_form'=>$this->tinyInteger(),

            'tests_count' => $this->smallInteger(),
            'test_type' => $this->tinyInteger()->defaultValue(1),
            'show_answer' => $this->tinyInteger(),
            'old_test_count' => $this->integer(),
            'current_test_count' => $this->integer(),
            'subject_id' => $this->integer(),
            'direction_id' => $this->integer(),
            'course_id' => $this->integer(),
            'semester_id' => $this->integer(),
            'control_type_id' => $this->tinyInteger(),
            'language_id' => $this->integer(),
        ];
    }

}
