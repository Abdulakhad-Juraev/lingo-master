<?php

namespace common\modules\regionmanager\models;

use soft\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "district".
 *
 * @property int $id
 * @property int $region_id
 * @property string|null $name_uz
 * @property string|null $name_oz
 * @property string|null $name_ru
 * @property string|null $name_en
 *
 * @property Region $region
 * @property-read null|string $name
 * @property Quarter[] $quarters
 */
class District extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'districts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id'], 'required'],
            [['region_id'], 'integer'],
            [['name_uz', 'name_oz', 'name_ru', 'name_en'], 'string', 'max' => 100],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => t('Region'),
            'name_uz' => 'Name Uz',
            'name_ru' => 'Name Ru',
            'name_en' => 'Name En',
        ];
    }

    /**
     * Gets query for [[Region]].
     *
     * @return ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * Gets query for [[Quarters]].
     *
     * @return ActiveQuery
     */
    public function getQuarters()
    {
        return $this->hasMany(Quarter::className(), ['district_id' => 'id']);
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name_uz;
    }

    /**
     * @param $regionId
     * @return array
     * $regionId - ga tegishli  ma'lumotlarni olib beradi
     */
    public static function getDistricts($regionId)
    {
        return ArrayHelper::map(self::find()->where(['region_id' => $regionId])->all(), 'id', 'name_uz');
    }
}
