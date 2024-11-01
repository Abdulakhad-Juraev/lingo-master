<?php

namespace common\modules\tariff\models;

use common\models\User;
use odilov\multilingual\behaviors\MultilingualBehavior;
use soft\db\ActiveQuery;
use soft\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "tariff".
 *
 * @property int $id
 * @property int|null $price
 * @property int|null $old_price
 * @property int|null $duration_number
 * @property string|null $duration_text
 * @property int|null $is_recommend
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $status
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property TariffLang[] $tariffLangs
 * @property UserTariff[] $userTariffs
 */
class Tariff extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tariff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'duration_number', 'duration_text', 'name_uz'], 'required'],
            [['name', 'short_description'], 'string'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['price', 'old_price', 'duration_number', 'is_recommend', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['duration_text'], 'string', 'max' => 255],
            ['is_recommend', 'default', 'value' => 0],
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
                'attributes' => ['name', 'short_description'],
                'languages' => $this->languages(),
            ],
        ];
    }

    public static function find(): ActiveQuery
    {
        return parent::find()->multilingual();
    }

    public static function durationTexts()
    {
        return [
            'day' => 'kun',
            'month' => 'oy',
            'year' => 'yil',
        ];
    }

    /**
     * @return string
     */
    public function getDurationTextName()
    {
        return ArrayHelper::getArrayValue(self::durationTexts(), $this->duration_text, $this->duration_text);
    }

    /**
     * @return string
     */
    public function getDuration()
    {

        return $this->duration_number . ' ' . $this->duration_text;
    }

    /**
     * @return string
     */
    public function getDurationName()
    {
        return $this->duration_number . ' ' . $this->getDurationTextName();
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price',
            'old_price' => 'Old Price',
            'duration_number' => 'Duration Number',
            'duration_text' => 'Duration Text',
            'is_recommend' => 'Is Recommend',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTariffLangs()
    {
        return $this->hasMany(TariffLang::className(), ['owner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTariffs()
    {
        return $this->hasMany(UserTariff::className(), ['tariff_id' => 'id']);
    }

    public static function map()
    {
        return ArrayHelper::map(self::find()->andWhere(['status' => self::STATUS_ACTIVE])->all(), 'id', 'name');
    }

    //</editor-fold>
}
