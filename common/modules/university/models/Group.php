<?php

namespace common\modules\university\models;

use common\models\User;
use odilov\multilingual\behaviors\MultilingualBehavior;
use odilov\multilingual\db\MultilingualLabelsTrait;
use soft\helpers\ArrayHelper;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "group".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $direction_id
 * @property int|null $course_id
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $language_id
 *
 * @property User $createdBy
 * @property Direction $direction
 * @property User $updatedBy
 */
class Group extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group';
    }
//    use MultilingualLabelsTrait;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_uz','direction_id','language_id','course_id'], 'required'],
            [['name_uz','name_ru','name_en'], 'string'],
            [['direction_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'language_id', 'course_id'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['direction_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direction::className(), 'targetAttribute' => ['direction_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'id']],
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
            'multilingual' => [
                'class' => MultilingualBehavior::class,
                'attributes' => ['name'],
                'languages' => $this->languages(),
            ],
        ];
    }

    public static function find(): \soft\db\ActiveQuery
    {
        return parent::find()->multilingual();
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Name'),
            'direction_id' => Yii::t('app', 'Direction'),
            'language_id' => Yii::t('app', 'Language'),
            'course_id' => Yii::t('app', 'Course'),
        ];
    }

    /**
     * @return array
     */
    public static function getGroups($direction_id): array
    {
        return ArrayHelper::map(self::find()->andWhere(['direction_id' => $direction_id])->active()->all(), 'id', 'name_uz');
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDirection()
    {
        return $this->hasOne(Direction::className(), ['id' => 'direction_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \soft\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'language_id']);
    }

    /**
     * @return \soft\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }
    //</editor-fold>
}
