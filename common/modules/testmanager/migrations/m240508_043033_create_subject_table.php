<?php
namespace common\modules\testmanager\migrations;

use soft\db\Migration;

/**
 * Handles the creation of table `{{%subject}}`.
 */
class m240508_043033_create_subject_table extends Migration
{

    public $tableName = '{{%subject}}';

    public $blameable = true;

    public $timestamp = true;

    public $status = true;
    public $multilingiualAttributes = ['name'];
    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            'id' => $this->primaryKey(),
            'name'=>$this->string(100),
            'is_free'=>$this->tinyInteger(),
            'price'=>$this->integer(),
            'started_at'=>$this->integer(),
            'finished_at'=>$this->integer(),
//            'status'=>$this->tinyInteger(),
            'duration'=>$this->integer(),
            'tests_count'=>$this->smallInteger(),
            'show_answer'=>$this->tinyInteger(),
        ];
    }

}
