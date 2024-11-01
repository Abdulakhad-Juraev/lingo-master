<?php

namespace common\models;

use soft\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "instructions".
 *
 * @property int $id
 * @property string|null $content
 * @property int|null $type_id
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $exam_type_id
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Instructions extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */

    public const TYPE_ID_LISTENING = 1;
    public const TYPE_ID_READING = 2;
    public const TYPE_ID_WRITING = 3;
    public const TYPE_ID_SPEAKING = 4;


    public const EXAM_TYPE_ID_TOEFL = 1;
    public const EXAM_TYPE_ID_IELTS = 2;

    public static function typesList(): array
    {
        return [
            self::TYPE_ID_LISTENING => Yii::t('app', 'Listening'),
            self::TYPE_ID_READING => Yii::t('app', 'Reading'),
            self::TYPE_ID_WRITING => Yii::t('app', 'Writing'),
            self::TYPE_ID_SPEAKING => Yii::t('app', 'Speaking'),
        ];
    }

    public static function examTypesList(): array
    {
        return [
            self::EXAM_TYPE_ID_TOEFL => Yii::t('app', 'Toefl'),
            self::EXAM_TYPE_ID_IELTS => Yii::t('app', 'Ielts'),
        ];
    }

    public function typeLabel(): string
    {
        return ArrayHelper::getValue(self::typesList(), $this->type_id, $this->type_id);
    }
    public function examTypeLabel(): string
    {
        return ArrayHelper::getValue(self::examTypesList(), $this->exam_type_id, $this->exam_type_id);
    }

    public static function tableName()
    {
        return 'instructions';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_id', 'exam_type_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            ['content', 'string'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
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

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
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
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    //</editor-fold>
}
