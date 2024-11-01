<?php

namespace common\modules\ieltsExam\models;

use common\models\User;
use common\modules\ieltsExam\models\traits\IeltsQuestionDynamicFormTrait;
use common\modules\toeflExam\models\EnglishExam;
use soft\db\ActiveQuery;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "ielts_questions".
 *
 * @property int $id
 * @property string|null $value
 * @property int|null $question_group_id
 * @property int|null $exam_id
 * @property int|null $group_type
 * @property int|null $section
 * @property int|null $type_id
 * @property string|null $info
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property IeltsOptions[] $ieltsOptions
 * @property User $createdBy
 * @property EnglishExam $exam
 * @property IeltsQuestionGroup $questionGroup
 * @property User $updatedBy
 */
class IeltsQuestions extends \soft\db\ActiveRecord
{
    use IeltsQuestionDynamicFormTrait;

    public const AudioUrl = "@frontend/web/uploads/ielts/ielts-speaking/audio";
    public $audioFile;
    public const TYPE_AUDIO = 1;
    public const TYPE_RADIO = 2;
    public const TYPE_TEXT = 3;

    //Sections
    public const SECTION_1 = 1;
    public const SECTION_2 = 2;
    public const SECTION_3 = 3;
    public const SECTION_4 = 4;

    // Ielts Question Group
    public const TYPE_LISTENING_GROUP = 1;
    public const TYPE_READING_GROUP = 2;
    public const TYPE_WRITING_GROUP = 3;
    public const TYPE_SPEAKING_GROUP = 4;

    public const SCENARIO_LISTENING = 'listening';
    public const SCENARIO_SPEAKING = 'speaking';
    public const SCENARIO_READING = 'reading';
    public const SCENARIO_WRITING = 'writing';


    //<editor-fold desc="Parent" defaultstate="collapsed">

    public static function tableName(): string
    {
        return 'ielts_questions';
    }

    public function rules()
    {
        return [
            [['section', 'group_type', 'question_group_id', 'exam_id', 'type_id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['value', 'info'], 'string'],
            ['audioFile', 'required', 'on' => [self::SCENARIO_SPEAKING]],
            [['audioFile'], 'file', 'extensions' => ['mp3', 'wav'], 'maxSize' => 1024 * 1024 * 10], // 10MB
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['exam_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnglishExam::className(), 'targetAttribute' => ['exam_id' => 'id']],
            [['question_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => IeltsQuestionGroup::className(), 'targetAttribute' => ['question_group_id' => 'id']],
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
            'value' => t('Value'),
            'question_group_id' => t('Question Group'),
            'exam_id' => t('Exam'),
            'type_id' => t('Type'),
            'info' => t('Information'),
        ];
    }

    //</editor-fold>

    public static function types(): array
    {
        return [
            self::TYPE_AUDIO => 'Audio',
            self::TYPE_RADIO => 'Radio',
            self::TYPE_TEXT => 'Text',
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['speaking'] = ['value', 'section', 'group_type', 'audioFile', 'type_id', 'exam_id', 'info', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        $scenarios['reading'] = ['value', 'section', 'type_id', 'question_group_id', 'exam_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        $scenarios['listening'] = ['value', 'section', 'type_id', 'question_group_id', 'exam_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        $scenarios['writing'] = ['value', 'group_type', 'section', 'info', 'type_id', 'exam_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return $scenarios;
    }

    public function typeName(): string
    {
        return self::types()[$this->type_id];
    }

    public static function sections(): array
    {
        return [
            self::SECTION_1 => 'Section 1',
            self::SECTION_2 => 'Section 2',
            self::SECTION_3 => 'Section 3',
            self::SECTION_4 => 'Section 4',
        ];
    }

    public static function speakingReadingSection(): array
    {
        return [
            self::SECTION_1 => 'Section 1',
            self::SECTION_2 => 'Section 2',
            self::SECTION_3 => 'Section 3',
        ];
    }

    public function sectionName(): string
    {
        return self::sections()[$this->section] ?? 'Unknown Section';
    }

    public static function groupTypes(): array
    {
        return [
            self::TYPE_LISTENING_GROUP => 'Listening',
            self::TYPE_READING_GROUP => 'Reading',
            self::TYPE_WRITING_GROUP => 'Writing',
            self::TYPE_SPEAKING_GROUP => 'Speaking',
        ];
    }

    public function groupTypeName(): string
    {
        return self::groupTypes()[$this->group_type] ?? 'Unknown group';
    }

    public function upload(): bool
    {
        if (!$this->isNewRecord && empty($this->audioFile)) {
            return $this->save(false);
        }
        if ($this->isNewRecord && empty($this->audioFile)) {
            $this->addError('audioFile', 'Audio file yuklang!');
            return false;
        }
        if ($this->validate()) {
            if (!$this->isNewRecord && !empty($this->audioFile)) {
                $currentFile = \Yii::getAlias(self::AudioUrl . '/' . $this->value);
                if (is_file($currentFile)) {
                    unlink($currentFile);
                }
            }
            $name = \Yii::$app->security->generateRandomString(16) . "." . $this->audioFile->extension;
            $path = self::AudioUrl . '/' . $name;
            try {
                FileHelper::createDirectory(\Yii::getAlias(self::AudioUrl));
            } catch (\Exception $e) {
                $this->addError('audioFile', $e->getMessage());
                return false;
            }

            if ($this->audioFile->saveAs($path)) {
                $this->value = $name;
                return $this->save(false);
            } else {
                return false;
            }
        }
        return false;
    }

    public function getAudioUrl()
    {
        return \Yii::$app->urlManager->hostInfo . "/uploads/ielts/ielts-speaking/audio/" . $this->value;
    }

    //<editor-fold desc="Relations" defaultstate="collapsed">

    public function getIeltsOptions(): ActiveQuery
    {
        IeltsOptions::setFields([
            'id',
            'text'
        ]);
        return $this->hasMany(IeltsOptions::className(), ['question_id' => 'id']);
    }

    public function getCorrectAnswer(): mixed
    {
        return $this->getIeltsOptions()->andWhere(['is_correct' => 1])->one()->id;
    }

    public function getCreatedBy(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getExam(): ActiveQuery
    {
        return $this->hasOne(EnglishExam::className(), ['id' => 'exam_id']);
    }

    public function getQuestionGroup(): ActiveQuery
    {
        return $this->hasOne(IeltsQuestionGroup::className(), ['id' => 'question_group_id']);
    }

    public function getUpdatedBy(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    //</editor-fold>
}
