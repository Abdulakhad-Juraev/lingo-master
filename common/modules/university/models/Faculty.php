<?php

namespace common\modules\university\models;

use common\models\User;
use odilov\multilingual\behaviors\MultilingualBehavior;
use soft\db\ActiveQuery;
use soft\helpers\ArrayHelper;
use soft\helpers\Html;
use soft\helpers\Url;
use Yii;

/**
 * This is the model class for table "faculty".
 *
 * @property int $id
 * @property int|null $status
 * @property string|null $name
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Faculty extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faculty';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name_uz', 'required'],
            [['name_uz','name_ru','name_en'], 'string'],
            [['status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

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
            'name' => Yii::t('app', 'Name'),
//            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public static function map()
    {
        return ArrayHelper::map(self::find()->andWhere(['status' => self::STATUS_ACTIVE])->all(), 'id', 'name');
    }
}
