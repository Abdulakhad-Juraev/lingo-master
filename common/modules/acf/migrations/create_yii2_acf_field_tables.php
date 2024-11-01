<?php


use yii\db\JsonExpression;
use yii\db\Migration;

/**
 * Class m210507_065616_create_yii2_acf_field_tables
 */
class create_yii2_acf_field_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%acf_field_type}}', [

            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
            'is_widget' => $this->boolean()->defaultValue(false),
            'widget_class' => $this->string(),
            'options' => $this->text(),
            'is_file_upload' => $this->boolean()->defaultValue(false)

        ]);

        $this->insertFieldTypes();

        $this->createTable('{{%acf_field}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'name' => $this->string(100)->notNull()->unique(),
            'type_id' => $this->integer(),
            'description' => $this->string(),
            'options' => $this->text(),
            'is_required' => $this->boolean()->defaultValue(false),
            'is_multilingual' => $this->boolean()->defaultValue(false),
            'placeholder' => $this->string(),
            'prepend' => $this->string(),
            'append' => $this->string(),
            'character_limit' => $this->smallInteger()->defaultValue(0),
            'is_active' => $this->boolean()->defaultValue(true),
            'view_type' => $this->string(20)->defaultValue('text'),

        ]);

        $this->createTable('{{%acf_field_value}}', [
            'id' => $this->primaryKey(),
            'field_id' => $this->integer(),
            'value' => $this->text(),
            'language' => $this->string(20),
        ]);

        $this->addForeignKey('fk_field_value_to_field', 'acf_field_value', 'field_id', 'acf_field', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_field_value_to_field', 'acf_field_value');
        $this->dropTable('{{%acf_field_value}}');
        $this->dropTable('{{%acf_field}}');
        $this->dropTable('{{%acf_field_type}}');
    }

    private function insertFieldTypes()
    {
        $this->batchInsert(
            '{{%acf_field_type}}',
            ['name', 'is_widget', 'widget_class', 'options', 'is_file_upload'],
            [
                ['Text input', false, '', new JsonExpression(['type' => 'text', 'class' => 'form-control']), false],
                ['Email input', false, '', new JsonExpression(['type' => 'email', 'class' => 'form-control']), false],
                ['Number input', false, '', new JsonExpression(['type' => 'number', 'class' => 'form-control']), false],
                ['Textarea', false, '', new JsonExpression(['type' => 'textarea', 'class' => 'form-control']), false],
                ['File input', false, '', new JsonExpression(['type' => 'file']), true],
                ['Phone number input', true, 'yii\widgets\MaskedInput', new JsonExpression(['mask' => '+\\9\\98\\(99\\) 999-99-99']), false],
            ]
        );
    }
}
