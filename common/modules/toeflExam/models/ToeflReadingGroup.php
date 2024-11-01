<?php

namespace common\modules\toeflExam\models;

use common\modules\usermanager\models\User;
use soft\db\ActiveQuery;

/**
 * This is the model class for table "toefl_reading_group".
 *
 * @property int $id
 * @property string|null $text
 * @property int|null $exam_id
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property ToeflQuestion[] $toeflQuestions
 * @property EnglishExam[] $englishExam
 * @property User $createdBy
 * @property User $updatedBy
 */
class ToeflReadingGroup extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    public static function tableName(): string
    {
        return 'toefl_reading_group';
    }


    public function rules()
    {
        return [
            [['text'], 'string'],
            [['status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['exam_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnglishExam::class, 'targetAttribute' => ['exam_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
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
            'info' => t('Information'),
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    public function getToeflQuestions(): ActiveQuery
    {
        return $this->hasMany(ToeflQuestion::className(), ['reading_group_id' => 'id']);
    }

    public function getExam(): ActiveQuery
    {
        return $this->hasOne(EnglishExam::class, ['id' => 'exam_id']);
    }

    public function getCreatedBy(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdatedBy(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    //</editor-fold>
}
