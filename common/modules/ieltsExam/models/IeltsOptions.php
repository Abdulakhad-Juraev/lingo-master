<?php

namespace common\modules\ieltsExam\models;

use common\models\User;

/**
 * This is the model class for table "ielts_options".
 *
 * @property int $id
 * @property string|null $text
 * @property int|null $question_id
 * @property int|null $is_correct
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property IeltsQuestions $question
 * @property User $updatedBy
 */
class IeltsOptions extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    public static function tableName(): string
    {
        return 'ielts_options';
    }

    public function rules()
    {
        return [
            [['text'], 'string'],
            [['question_id', 'is_correct', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => IeltsQuestions::className(), 'targetAttribute' => ['question_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
        ];
    }

    public function labels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'question_id' => 'Question ID',
            'is_correct' => 'Is Correct',
        ];
    }

    //</editor-fold>

    public function getIsCorrectIcon()
    {
        return $this->is_correct ? '<span style="color: green"><i class="fa fa-check"></i></span>' : '<span style="color: red"><i class="fa fa-times"></i></span>';
    }

    //<editor-fold desc="Relations" defaultstate="collapsed">

    public function getCreatedBy(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getQuestion(): \yii\db\ActiveQuery
    {
        return $this->hasOne(IeltsQuestions::className(), ['id' => 'question_id']);
    }

    public function getUpdatedBy(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    //</editor-fold>
}
