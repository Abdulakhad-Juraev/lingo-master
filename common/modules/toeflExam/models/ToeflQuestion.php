<?php

namespace common\modules\toeflExam\models;

use api\modules\toefl\models\Options;
use common\models\User;
use common\modules\testmanager\models\Option;
use common\modules\toeflExam\models\traits\ToeflQuestionDynamicFormTrait;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "toefl_question".
 *
 * @property int $id
 * @property string|null $value
 * @property string|null $title
 * @property int|null $type_id
 * @property int|null $test_type_id
 * @property int|null $conversation_toefl_id
 * @property int|null $exam_id
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property ToeflOption[] $toeflOptions
 * @property User $createdBy
 * @property EnglishExam $exam
 * @property User $updatedBy
 * @property ToeflReadingGroup $readingGroup
 * @property ToeflListeningGroup $listeningGroup
 * @property ToeflOption $randomOptionsWriting
 */
class ToeflQuestion extends \soft\db\ActiveRecord
{
    use ToeflQuestionDynamicFormTrait;

    public $audioFile;
    public const ConversationAudio = "@frontend/web/uploads/toefl/listening/question";
    public const SCENARIO_LISTENING = 'listening';
    public const SCENARIO_WRITING = 'writing';
    public const SCENARIO_READING = 'reading';

    public const TYPE_LISTENING = 1;
    public const TYPE_WRITING = 2;
    public const TYPE_READING = 3;


    public const ABC_TYPE_ID_A = 1;
    public const ABC_TYPE_ID_B = 2;

    public const ABC_TYPE_C = 3;

    public static function abcTypes()
    {
        return [
            self::ABC_TYPE_ID_A => 'A',
            self::ABC_TYPE_ID_B => 'B',
            self::ABC_TYPE_C => 'C'
        ];
    }

    public static function writingTypes()
    {
        return [
            self::ABC_TYPE_ID_A => 'A',
            self::ABC_TYPE_ID_B => 'B',
        ];
    }

    public function abcTypeNames()
    {
        return self::abcTypes()[$this->test_type_id];
    }

    public function writingTypeNames()
    {
        return self::writingTypes()[$this->test_type_id];
    }

    public static function types(): array
    {
        return [
            self::TYPE_LISTENING => 'listening',
            self::TYPE_WRITING => 'writing',
            self::TYPE_READING => 'reading',
        ];
    }

    public function typeName(): string
    {
        return self::types()[$this->type_id];
    }
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'toefl_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'string', 'on' => 'writing'],
            [['value'], 'string', 'on' => 'reading'],
            [['reading_group_id', 'value', 'exam_id'], 'required', 'on' => 'reading'],
            [['listening_group_id', 'exam_id'], 'required', 'on' => 'listening'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['value', 'type_id', 'test_type_id', 'exam_id'], 'required', 'on' => 'writing'],
            [['type_id', 'test_type_id', 'reading_group_id', 'listening_group_id', 'exam_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['exam_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnglishExam::className(), 'targetAttribute' => ['exam_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['writing'] = ['value', 'type_id', 'test_type_id', 'exam_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        $scenarios['reading'] = ['value', 'type_id', 'reading_group_id', 'exam_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        $scenarios['listening'] = ['value', 'type_id', 'test_type_id', 'exam_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return $scenarios;
    }

    public function upload(): bool
    {
        // Check if it's an existing record without a new file, then just save without file update
        if (!$this->isNewRecord && empty($this->audioFile)) {
            return $this->save(false);
        }
        if ($this->isNewRecord && empty($this->audioFile)) {
            $this->addError('audioFile', 'Audio file yuklang');
            return false;
        }

        // Validate the model attributes including the file
        if ($this->validate()) {
            // If it's an existing record with a new file, delete the old file first
            if (!$this->isNewRecord && !empty($this->audioFile)) {
                $currentFile = \Yii::getAlias(self::ConversationAudio . '/' . $this->value);
                if (is_file($currentFile)) {
                    unlink($currentFile);
                }
            }
            // Generate a unique name for the new file
            $name = \Yii::$app->security->generateRandomString(16) . "." . $this->audioFile->extension;
            $path = self::ConversationAudio . '/' . $name;
            // Create the directory if it doesn't exist
            try {
                FileHelper::createDirectory(\Yii::getAlias(self::ConversationAudio));
            } catch (\Exception $e) {
                $this->addError('audioFile', $e->getMessage());
                return false;
            }

            // Save the uploaded file to the designated path
            if ($this->audioFile->saveAs($path)) {
                // Update the model attribute with the new file name
                $this->value = $name;
                // Save the model without running validation again (save(false))
                return $this->save(false);
            } else {
                // Return false if saving the file failed
                return false;
            }
        }

        // Return false if validation fails
        return false;
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
            'value' => 'Value',
            'title' => 'Title',
            'type_id' => 'Type ID',
            'test_type_id' => 'Abc Type ID',
            'conversation_toefl_id' => 'Conversation Toefl ID',
            'exam_id' => 'Exam ID',
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    public function getToeflOptions(): ActiveQuery
    {
        ToeflOption::setFields([
            'id',
            'text'
        ]);
        return $this->hasMany(ToeflOption::className(), ['toefl_question_id' => 'id']);
    }
    public function getToeflUserOptions(): \soft\db\ActiveQuery
    {
        return $this->hasMany(ToeflUserOption::class, ['question_id' => 'id']);
    }

    public function getCreatedBy(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getExam(): ActiveQuery
    {
        return $this->hasOne(EnglishExam::className(), ['id' => 'exam_id']);
    }
    public function getListeningGroup(): ActiveQuery
    {
        return $this->hasOne(ToeflListeningGroup::className(), ['id' => 'listening_group_id']);
    }
    public function getReadingGroup(): ActiveQuery
    {
        return $this->hasOne(ToeflReadingGroup::className(), ['id' => 'reading_group_id']);
    }
    public function getUpdatedBy(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    //</editor-fold>
    public function getAudioUrl(): string
    {
        return "/uploads/toefl/listening/question/" . $this->value;
    }

    public function lastQuestion()
    {
        return self::find()
            ->andWhere(['exam_id' => $this->exam_id, 'listening_group_id' => $this->listening_group_id])
            ->orderBy(['id' => SORT_DESC])
            ->limit(1)
            ->one()
            ->value ?? 0;
    }
    public function getCorrectAnswer(): mixed
    {
        return $this->getToeflOptions()->andWhere(['is_correct' => 1])->one()->id;
    }
    public function getRandomOptionsWriting()
    {
        return $this->getToeflOptions()->orderBy(new Expression('rand()'));
    }
}
