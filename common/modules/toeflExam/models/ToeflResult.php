<?php

namespace common\modules\toeflExam\models;

use api\modules\toefl\models\ListeningGroup;
use api\modules\toefl\models\ToeflQuestion;
use common\models\User;
use soft\db\ActiveQuery;
use soft\helpers\ArrayHelper;

/**
 * This is the model class for table "toefl_result".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $exam_id
 * @property int|null $started_at
 * @property int|null $started_at_listening
 * @property int|null $started_at_reading
 * @property int|null $started_at_writing
 * @property string|null $cefr_level
 * @property int|null $expire_at
 * @property int|null $expire_at_listening
 * @property int|null $expire_at_reading
 * @property int|null $expire_at_writing
 * @property int|null $reading_duration
 * @property int|null $writing_duration
 * @property int|null $listening_duration
 * @property int|null $correct_answers_listening
 * @property int|null $correct_answers_reading
 * @property int|null $correct_answers_writing
 * @property int|null $price
 * @property int|null $finished_at
 * @property int|null $finished_at_listening
 * @property int|null $finished_at_reading
 * @property int|null $finished_at_writing
 * @property float|null $writing_score
 * @property float|null $listening_score
 * @property float|null $reading_score
 * @property int|null $step
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property EnglishExam $exam
 * @property User $updatedBy
 * @property User $user
 * @property ToeflResultItem[] $toeflResultItems
 */
class ToeflResult extends \soft\db\ActiveRecord
{
    public $total_result;
    public const STEP_LISTENING = 1;
    public const STEP_WRITING = 2;
    public const STEP_READING = 3;
    public const STEP_FINISHED = 4;

    public static function steps()
    {
        return [
            self::STEP_LISTENING => 'Listening',
            self::STEP_READING => 'Reading',
            self::STEP_WRITING => 'Writing',
        ];
    }

    public function stepName()
    {
        return ArrayHelper::getValue(self::steps(), $this->step, $this->step);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'toefl_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'exam_id', 'started_at', 'started_at_listening', 'started_at_reading', 'started_at_writing', 'expire_at', 'expire_at_listening', 'expire_at_reading', 'expire_at_writing', 'listening_duration', 'reading_duration', 'writing_duration', 'correct_answers_listening', 'correct_answers_reading', 'correct_answers_writing', 'price', 'finished_at', 'finished_at_listening', 'finished_at_reading', 'finished_at_writing', 'step', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['listening_score', 'reading_score', 'writing_score'], 'number'],
            [['correct_answers_listening', 'correct_answers_reading', 'correct_answers_writing'], 'default', 'value' => 0],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['exam_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnglishExam::class, 'targetAttribute' => ['exam_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => t('User'),
            'exam_id' => t('Exam'),
            'cefr_level' => t('CEFR Level'),
            'started_at' => t('Started At'),
            'started_at_listening' => 'Started At Listening',
            'started_at_reading' => 'Started At Reading',
            'started_at_writing' => 'Started At Writing',
            'expire_at' => 'Expire At',
            'expire_at_listening' => 'Expire At Listening',
            'expire_at_reading' => 'Expire At Reading',
            'expire_at_writing' => 'Expire At Writing',
            'reading_duration' => 'Reading Duration',
            'writing_duration' => 'Writing Duration',
            'listening_duration' => 'Listening Duration',
            'correct_answers_listening' => 'Correct Answers Listening',
            'correct_answers_reading' => 'Correct Answers Reading',
            'correct_answers_writing' => 'Correct Answers Writing',
            'price' => t('Cost'),
            'finished_at' => 'Finished At',
            'finished_at_listening' => 'Finished At Listening',
            'finished_at_reading' => 'Finished At Reading',
            'finished_at_writing' => 'Finished At Writing',
            'step' => 'Step',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExam()
    {
        return $this->hasOne(EnglishExam::class, ['id' => 'exam_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToeflResultItems()
    {
        return $this->hasMany(ToeflResultItem::class, ['result_id' => 'id']);
    }

    public function getToeflResultItemsWriting()
    {
        return $this->hasMany(ToeflResultItem::class, ['result_id' => 'id'])->andWhere(['is_used' => 0]);
    }



    /**
     * Calculate the total score by summing the listening, reading, and writing scores.
     */
    public function calculateTotalScore()
    {
        $this->total_result = (int)(($this->listening_score + $this->writing_score + $this->reading_score) * 10 / 3);
        $this->updateCEFRLevel();
    }

    public function getToeflResult()
    {
        return (int)(($this->listening_score + $this->writing_score + $this->reading_score) * 10 / 3);
    }

    /**
     * Determine the CEFR level based on the total score.
     */
    private function updateCEFRLevel()
    {
        if ($this->total_result >= 310 && $this->total_result <= 343) {
            $this->cefr_level = 'A1';
        } elseif ($this->total_result >= 344 && $this->total_result <= 426) {
            $this->cefr_level = 'A2';
        } elseif ($this->total_result >= 427 && $this->total_result <= 497) {
            $this->cefr_level = 'B1';
        } elseif ($this->total_result >= 498 && $this->total_result <= 543) {
            $this->cefr_level = 'B2';
        } elseif ($this->total_result >= 544 && $this->total_result <= 626) {
            $this->cefr_level = 'C1';
        } elseif ($this->total_result >= 627 && $this->total_result <= 677) {
            $this->cefr_level = 'C2';
        }
    }
}