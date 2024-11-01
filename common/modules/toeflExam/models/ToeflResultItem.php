<?php

namespace common\modules\toeflExam\models;

use api\modules\toefl\models\ListeningGroup;
use common\models\User;
use Yii;

/**
 * This is the model class for table "toefl_result_item".
 *
 * @property int|null $id
 * @property int|null $result_id
 * @property int|null $question_id
 * @property int|null $user_answer_id
 * @property int|null $original_answer_id
 * @property int|null $reading_group_id
 * @property int|null $listening_group_id
 * @property int|null $is_correct
 * @property int|null $type_id
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property boolean|null $is_used
 *
 * @property User $createdBy
 * @property ToeflOption $originalAnswer
 * @property ToeflQuestion $question
 * @property ToeflResult $result
 * @property User $updatedBy
 * @property ToeflOption $userAnswer
 */
class ToeflResultItem extends \soft\db\ActiveRecord
{
    public const TYPE_LISTENING = 1;
    public const TYPE_WRITING = 2;
    public const TYPE_READING = 3;
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'toefl_result_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['result_id', 'type_id', 'reading_group_id', 'listening_group_id', 'question_id', 'user_answer_id', 'original_answer_id', 'is_correct', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            ['is_used', 'boolean'],
            [['original_answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => ToeflOption::className(), 'targetAttribute' => ['original_answer_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => ToeflQuestion::className(), 'targetAttribute' => ['question_id' => 'id']],
            [['result_id'], 'exist', 'skipOnError' => true, 'targetClass' => ToeflResult::className(), 'targetAttribute' => ['result_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['user_answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => ToeflOption::className(), 'targetAttribute' => ['user_answer_id' => 'id']],
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
            'result_id' => 'Result ID',
            'question_id' => 'Question ID',
            'user_answer_id' => 'User Answer ID',
            'original_answer_id' => 'Original Answer ID',
            'is_correct' => 'Is Correct',
            'status' => 'Status',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    public function getOriginalAnswer()
    {
        return $this->hasOne(ToeflOption::className(), ['id' => 'original_answer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(ToeflQuestion::className(), ['id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResult()
    {
        return $this->hasOne(ToeflResult::className(), ['id' => 'result_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAnswer()
    {
        return $this->hasOne(ToeflOption::className(), ['id' => 'user_answer_id']);
    }

    public function getListeningGroup()
    {
        return $this->hasOne(ListeningGroup::className(), ['id' => 'listening_group_id']);
    }

    //</editor-fold>
}
