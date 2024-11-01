<?php

namespace common\modules\ieltsExam\models;

use common\models\User;
use soft\db\ActiveQuery;

/**
 * This is the model class for table "ielts_result_item".
 *
 * @property int $id
 * @property int|null $result_id
 * @property int|null $question_id
 * @property int|null $user_answer_id
 * @property int|null $original_answer_id
 * @property int|null $is_correct
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $type_id
 * @property boolean|null $is_used
 * @property int|null $updated_at
 * @property string|null $value
 * @property int|null $input_type
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property IeltsQuestions $question
 * @property IeltsOptions $originalAnswer
 */
class IeltsResultItem extends \soft\db\ActiveRecord
{
    public const AudioUrl = "@frontend/web/uploads/ielts/speaking-answers/";
    const SCENARIO_SPEAKING = 'speaking';

    public const IS_USED_TRUE = 1;
    public const IS_USED_FALSE = 0;
    public const TYPE_LISTENING = 1;
    public const TYPE_READING = 2;
    public const TYPE_WRITING = 3;
    public const TYPE_SPEAKING = 4;

    public const INPUT_TYPE_AUDIO = 1;
    public const INPUT_TYPE_RADIO = 2;
    public const INPUT_TYPE_TEXT = 3;


    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ielts_result_item';
    }

    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['result_id', 'type_id', 'question_id'], 'required'],
            [['result_id', 'is_used', 'type_id', 'input_type', 'question_id', 'user_answer_id', 'original_answer_id', 'is_correct', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            ['is_used', 'default', 'value' => self::IS_USED_FALSE],
            ['value', 'string'],
            [['value'], 'file', 'extensions' => 'mp3, wav', 'maxSize' => 1024 * 1024 * 10, 'on' => self::SCENARIO_SPEAKING], // Max 10MB upload
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SPEAKING] = ['value'];
        return $scenarios;
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
            'question_id' => t('Question'),
            'user_answer_id' => t('User Answer'),
            'original_answer_id' => t('Original Answer'),
            'is_correct' => t('Is Correct'),
            'value' => 'Value'
        ];
    }

    //</editor-fold>

    public function getAudioUrl()
    {
        return \Yii::$app->urlManager->hostInfo . $this->value;
    }


    //<editor-fold desc="Relations" defaultstate="collapsed">

    public function getCreatedBy(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUserAnswer(): ActiveQuery
    {
        return $this->hasOne(IeltsOptions::className(), ['id' => 'user_answer_id']);
    }

    public function getUpdatedBy(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getOriginalAnswer(): ActiveQuery
    {
        return $this->hasOne(IeltsOptions::className(), ['id' => 'original_answer_id']);
    }

    public function getQuestion()
    {
        return $this->hasOne(IeltsQuestions::className(), ['id' => 'question_id']);
    }

    public function getResult()
    {
        return $this->hasOne(IeltsResult::className(), ['id' => 'result_id']);
    }

    //</editor-fold>
}
