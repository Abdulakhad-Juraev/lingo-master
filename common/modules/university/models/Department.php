<?php

namespace common\modules\university\models;


use common\models\User;
use odilov\multilingual\behaviors\MultilingualBehavior;
use soft\db\ActiveRecord;
use soft\helpers\ArrayHelper;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property string $name
 * @property int|null $faculty_id
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property Faculty $faculty
 * @property User $updatedBy
 */
class Department extends ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_uz','faculty_id'], 'required'],
            [['name_uz','name_ru','name_en'], 'string'],
            [['faculty_id', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Faculty::className(), 'targetAttribute' => ['faculty_id' => 'id']],
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
            'faculty_id' => Yii::t('app', 'Faculty'),
        ];
    }

    public static function map()
    {
        return ArrayHelper::map(self::find()->andWhere(['status' => self::STATUS_ACTIVE])->all(), 'id', 'name');
    }

    /**
     * @param $faculty_id
     * @return array
     */
    public static function getDepartments($faculty_id)
    {
        return ArrayHelper::map(self::find()->andWhere(['faculty_id' => $faculty_id])->active()->all(), 'id', 'name_uz');
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
    public function getFaculty()
    {
        return $this->hasOne(Faculty::className(), ['id' => 'faculty_id']);
    }

    /**
     * @return ActiveQuery
     */

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    //</editor-fold>
}
