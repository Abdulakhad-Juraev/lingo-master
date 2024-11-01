<?php

namespace common\modules\ieltsExam\models;

use api\modules\ieltsExam\models\IeltsQuestions;
use common\models\User;
use common\modules\toeflExam\models\EnglishExam;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "ielts_question_group".
 *
 * @property int $id
 * @property int|null $exam_id
 * @property string|null $content
 * @property string|null $audio
 * @property string|null $audioFile
 * @property int|null $section
 * @property int|null $type_id
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property EnglishExam $exam
 * @property User $updatedBy
 * @property self $audioUrl
 * @property IeltsQuestions[] $ieltsQuestions
 */
class IeltsQuestionGroup extends \soft\db\ActiveRecord
{
    public const AudioUrl = "@frontend/web/uploads/ielts/ielts-group/audio";
    public $audioFile;

    public const TYPE_LISTENING = 1;
    public const TYPE_READING = 2;
    public const TYPE_SPEAKING = 3;

    public const SECTION_1 = 1;
    public const SECTION_2 = 2;
    public const SECTION_3 = 3;
    public const SECTION_4 = 4;

    public const SCENARIO_LISTENING = 'listening';
    public const SCENARIO_SPEAKING = 'speaking';

    //<editor-fold desc="Parent" defaultstate="collapsed">

    public static function tableName(): string
    {
        return 'ielts_question_group';
    }

    public function rules()
    {
        return [
            [['exam_id', 'section', 'type_id',], 'required'],
            [['exam_id', 'section', 'type_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string', 'max' => 15000],
            ['audioFile', 'required', 'on' => [self::SCENARIO_LISTENING]],
            [['audioFile'], 'file', 'extensions' => 'mp3, wav', 'maxSize' => 1024 * 1024 * 12], // maxSize ni baytlarda ko'rsatilgan
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['exam_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnglishExam::className(), 'targetAttribute' => ['exam_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_LISTENING] = ['exam_id', 'section', 'type_id', 'content', 'audioFile', 'audio', 'status', 'type_id', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        $scenarios[self::SCENARIO_SPEAKING] = ['exam_id', 'section', 'type_id', 'content', 'status', 'type_id', 'created_by', 'updated_by', 'created_at', 'updated_at'];
        return $scenarios;
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
            'exam_id' => 'Exam ID',
            'content' => 'Content',
            'audio' => 'Audio',
            'section' => 'Section',
            'type_id' => 'Type',
            'audioFile' => 'AudioFile'
        ];
    }

    //</editor-fold>

    public static function types(): array
    {
        return [
            self::TYPE_LISTENING => 'Listening',
            self::TYPE_READING => 'Reading',
            self::TYPE_SPEAKING => 'Speaking',
        ];
    }

    public function typeName(): string
    {
        return self::types()[$this->type_id];
    }

    public static function sectionsListening()
    {
        return [
            self::SECTION_1 => 'Section 1',
            self::SECTION_2 => 'Section 2',
            self::SECTION_3 => 'Section 3',
            self::SECTION_4 => 'Section 4',
        ];
    }

    public static function sectionsReadingSpeaking(): array
    {
        return [
            self::SECTION_1 => 'Section 1',
            self::SECTION_2 => 'Section 2',
            self::SECTION_3 => 'Section 3',
        ];
    }

    public function sectionName(): string
    {
        return self::sectionsListening()[$this->section];
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
                $currentFile = \Yii::getAlias(self::AudioUrl . '/' . $this->audio);
                if (is_file($currentFile)) {
                    unlink($currentFile);
                }
            }
            // Generate a unique name for the new file
            $name = \Yii::$app->security->generateRandomString(16) . "." . $this->audioFile->extension;
            $path = self::AudioUrl . '/' . $name;
            // Create the directory if it doesn't exist
            try {
                FileHelper::createDirectory(\Yii::getAlias(self::AudioUrl));
            } catch (\Exception $e) {
                $this->addError('audioFile', $e->getMessage());
                return false;
            }

            // Save the uploaded file to the designated path
            if ($this->audioFile->saveAs($path)) {
                // Update the model attribute with the new file name
                $this->audio = $name;
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


    //<editor-fold desc="Relations" defaultstate="collapsed">


    public function getCreatedBy(): \soft\db\ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }


    public function getExam(): \soft\db\ActiveQuery
    {
        return $this->hasOne(EnglishExam::className(), ['id' => 'exam_id']);
    }


    public function getUpdatedBy(): \soft\db\ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }


    public function getIeltsQuestions(): \soft\db\ActiveQuery
    {
        IeltsQuestions::setFields([
            'id',
            'value',
            'options' => function (IeltsQuestions $question) {
                return $question->ieltsOptions;
            }
        ]);
        return $this->hasMany(IeltsQuestions::className(), ['question_group_id' => 'id']);
    }

    //</editor-fold>

    public function getAudioUrl()
    {
        return \Yii::$app->urlManager->hostInfo . "/uploads/ielts/ielts-group/audio/" . $this->audio;
    }
}
