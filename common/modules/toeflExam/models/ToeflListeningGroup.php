<?php

namespace common\modules\toeflExam\models;

use common\models\User;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "toefl_listening_group".
 *
 * @property int $id
 * @property string|null $audio
 * @property int|null $exam_id
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
 * @property ToeflQuestion[] $toeflQuestions
 */
class ToeflListeningGroup extends \soft\db\ActiveRecord
{
    public const AudioUrl = "@frontend/web/uploads/toefl/toefl-listening-group/audio";


    public $audioFile;
    public const TEST_TYPE_ID_A = 1;
    public const TEST_TYPE_ID_B = 2;
    public const TEST_TYPE_ID_C = 3;

    public static function testTypes()
    {
        return [
            self::TEST_TYPE_ID_A => 'A',
            self::TEST_TYPE_ID_B => 'B',
            self::TEST_TYPE_ID_C => 'C',
        ];
    }

    public function testTypeName()
    {
        return self::testTypes()[$this->type_id];
    }
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'toefl_listening_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exam_id', 'type_id'], 'required'],
            [['audio'], 'string'],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['audioFile'], 'file', 'extensions' => 'mp3, wav', 'maxSize' => 1024 * 1024 * 12], // maxSize ni baytlarda ko'rsatilgan
            [['exam_id', 'type_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['exam_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnglishExam::className(), 'targetAttribute' => ['exam_id' => 'id']],
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

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => 'ID',
            'audio' => 'Audio',
            'exam_id' => 'Exam ID',
            'type_id' => 'Type ID',
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
    public function getExam()
    {
        return $this->hasOne(EnglishExam::className(), ['id' => 'exam_id']);
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
    public function getToeflQuestions()
    {
        return $this->hasMany(ToeflQuestion::className(), ['listening_group_id' => 'id']);
    }
    public function getResultItems()
    {
        return $this->hasMany(ToeflResultItem::className(), ['listening_group_id' => 'id']);
    }

    public function getAudioUrl()
    {
        return \Yii::$app->urlManager->hostInfo."/uploads/toefl/toefl-listening-group/audio/" . $this->audio;
    }

    //</editor-fold>


}
