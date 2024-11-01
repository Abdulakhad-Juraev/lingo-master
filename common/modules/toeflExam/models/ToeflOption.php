<?php

namespace common\modules\toeflExam\models;

use common\models\User;

/**
 * This is the model class for table "toefl_option".
 *
 * @property int $id
 * @property string|null $text
 * @property int|null $is_correct
 * @property int|null $toefl_question_id
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property ToeflQuestion $toeflQuestion
 * @property User $updatedBy
 */
class ToeflOption extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'toefl_option';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_correct', 'toefl_question_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['toefl_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => ToeflQuestion::className(), 'targetAttribute' => ['toefl_question_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'is_correct' => 'Is Correct',
            'toefl_question_id' => 'Toefl Question ID',
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToeflQuestion()
    {
        return $this->hasOne(ToeflQuestion::className(), ['id' => 'toefl_question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    //</editor-fold>

    public function getIsAnswerIcon()
    {
        return $this->is_correct ? '<span style="color: green"><i class="fa fa-check"></i></span>' : '<span style="color: red"><i class="fa fa-times"></i></span>';
    }
}
