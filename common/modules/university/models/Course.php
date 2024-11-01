<?php

namespace common\modules\university\models;

use common\modules\usermanager\models\User;
use odilov\multilingual\behaviors\MultilingualBehavior;
use soft\db\ActiveQuery;
use soft\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "course".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Course extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_uz'], 'required'],
            [['name'], 'string'],
            [['status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
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
            'multilingual' => [
                'class' => MultilingualBehavior::class,
                'attributes' => ['name'],
                'languages' => $this->languages(),
            ],
        ];
    }
    public static function find(): ActiveQuery
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

    public static function map(): array
    {
        return ArrayHelper::map(self::find()->andWhere(['status' => self::STATUS_ACTIVE])->all(), 'id', 'name');
    }

    //</editor-fold>
}
