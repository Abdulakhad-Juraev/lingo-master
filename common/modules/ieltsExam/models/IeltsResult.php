<?php

namespace common\modules\ieltsExam\models;

use common\models\User;
use common\modules\toeflExam\models\EnglishExam;
use soft\db\ActiveQuery;
use soft\helpers\ArrayHelper;

/**
 * This is the model class for table "ielts_result".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $exam_id
 * @property int|null $started_at
 * @property int|null $started_at_listening
 * @property int|null $started_at_reading
 * @property int|null $started_at_writing
 * @property int|null $started_at_speaking
 * @property int|null $expired_at
 * @property int|null $expired_at_listening
 * @property int|null $finished_at_listening
 * @property int|null $finished_at_writing
 * @property int|null $finished_at_reading
 * @property int|null $finished_at_speaking
 * @property int|null $expired_at_reading
 * @property int|null $expired_at_writing
 * @property int|null $expired_at_speaking
 * @property int|null $listening_duration
 * @property int|null $reading_duration
 * @property int|null $writing_duration
 * @property int|null $speaking_duration
 * @property int|null $correct_answers_listening
 * @property int|null $correct_answers_reading
 * @property float|null $listening_score 7.5
 * @property float|null $reading_score 7.5
 * @property float|null $writing_score 7.5
 * @property float|null $speaking_score 7.5
 * @property int|null $step listening/reading/writing/speaking
 * @property int|null $finished_at
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
 * @property IeltsQuestionGroup $questionsListening
 * @property IeltsQuestionGroup $writingQuestions
 * @property IeltsQuestionGroup $speakingQuestions
 */
class IeltsResult extends \soft\db\ActiveRecord
{
    public const STEP_LISTENING = 1;
    public const STEP_READING = 2;
    public const STEP_WRITING = 3;
    public const STEP_SPEAKING = 4;
    public const STEP_FINISHED = 5;


    public const STATUS_ACTIVE = 1;

    public const STATUS_INACTIVE = 0;

    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ielts_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'exam_id', 'price', 'started_at', 'expired_at'], 'required'],
            [['user_id', 'exam_id', 'price', 'started_at', 'started_at_listening', 'started_at_reading', 'started_at_writing', 'started_at_speaking', 'expired_at', 'expired_at_listening', 'expired_at_reading', 'expired_at_writing', 'expired_at_speaking', 'listening_duration', 'reading_duration', 'writing_duration', 'speaking_duration', 'correct_answers_listening', 'correct_answers_reading', 'step', 'finished_at', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'finished_at_speaking', 'finished_at_reading', 'finished_at_writing', 'finished_at_listening'], 'integer'],
            [['listening_score', 'reading_score', 'writing_score', 'speaking_score'], 'number'],
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
    public function labels()
    {
        return [
            'id' => 'ID',
            'user_id' => t('User'),
            'exam_id' => t('Exam'),
            'started_at' => t('Started at'),
            'started_at_listening' => t('Started At Listening'),
            'started_at_reading' => t('Started At Reading'),
            'started_at_writing' => t('Started At Writing'),
            'started_at_speaking' => t('Started At Speaking'),
            'expired_at' => t('Expired At'),
            'expired_at_listening' => t('Expired At Listening'),
            'expired_at_reading' => t('Expired At Reading'),
            'expired_at_writing' => t('Expired At Writing'),
            'expired_at_speaking' => t('Expired At Speaking'),
            'listening_duration' => t('Listening Duration'),
            'reading_duration' => t('Reading Duration'),
            'writing_duration' => t('Writing Duration'),
            'speaking_duration' => t('Speaking Duration'),
            'correct_answers_listening' => t('Correct Answers Listening'),
            'correct_answers_reading' => t('Correct Answers Reading'),
            'listening_score' => t('Listening Score'),
            'reading_score' => t('Reading Score'),
            'writing_score' => t('Writing Score'),
            'speaking_score' => t('Speaking Score'),
            'step' => t('Step'),
            'finished_at' => t('Finished'),
            'badeScore' => t('Band Score'),
        ];
    }

    //</editor-fold>

    public static function steps(): array
    {
        return [
            self::STEP_LISTENING => 'Listening',
            self::STEP_READING => 'Reading',
            self::STEP_WRITING => 'Writing',
            self::STEP_SPEAKING => 'Speaking',
        ];
    }

    public function stepName()
    {
        return ArrayHelper::getValue(self::steps(), $this->step, $this->step);
    }



    //<editor-fold desc="Relations" defaultstate="collapsed">


    public function getIeltsResultItems(): ActiveQuery
    {
        return $this->hasMany(IeltsResultItem::class, ['result_id' => 'id']);
    }

    public function getCreatedBy(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getExam(): ActiveQuery
    {
        return $this->hasOne(EnglishExam::class, ['id' => 'exam_id']);
    }

    public function getUpdatedBy(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }


    public function getIeltsBandScore()
    {

        if ($this->speaking_score && $this->writing_score) {
            $averageScore = ($this->listening_score + $this->writing_score + $this->reading_score + $this->speaking_score) / 4;
            $bandScore = round($averageScore * 2) / 2;
            return max(0, min(9, $bandScore));
        }
        return 0;
    }
    //</editor-fold>


}
