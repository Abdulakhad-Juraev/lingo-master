<?php

namespace common\modules\ieltsExam\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "ielts_question_group_result".
 *
 * @property int $id
 * @property int|null $result_id
 * @property int|null $group_id
 * @property int|null $user_id
 * @property int|null $is_used
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $type_id
 *
 * @property User $createdBy
 * @property IeltsQuestionGroup $group
 * @property IeltsResult $result
 * @property User $updatedBy
 * @property User $user
 */
class IeltsQuestionGroupResult extends \soft\db\ActiveRecord
{
    public const IS_USED_TRUE = 1;
    public const IS_USED_FALSE = 0;
    //<editor-fold desc="Parent" defaultstate="collapsed">
    public const TYPE_LISTENING = 1;
    public const TYPE_READING = 2;
    public const TYPE_SPEAKING = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ielts_question_group_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['is_used', 'default', 'value' => self::IS_USED_FALSE],
            [['result_id', 'group_id', 'user_id', 'is_used', 'type_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => IeltsQuestionGroup::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['result_id'], 'exist', 'skipOnError' => true, 'targetClass' => IeltsResult::className(), 'targetAttribute' => ['result_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'group_id' => 'Group ID',
            'user_id' => 'User ID',
            'is_used' => 'Is Used',
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
    public function getGroup()
    {
        return $this->hasOne(IeltsQuestionGroup::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResult()
    {
        return $this->hasOne(IeltsResult::className(), ['id' => 'result_id']);
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    //</editor-fold>
}
