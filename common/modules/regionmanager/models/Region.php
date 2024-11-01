<?php

namespace common\modules\regionmanager\models;

use soft\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "region".
 *
 * @property int $id
 * @property string|null $name_uz
 * @property string|null $name_oz
 * @property string|null $name_ru
 * @property string|null $name_en
 *
 * @property-read null|string $name
 * @property District[] $districts
 */
class Region extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_uz', 'name_oz', 'name_ru', 'name_en'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_uz' => 'Name Uz',
            'name_oz' => 'Name Oz',
            'name_ru' => 'Name Ru',
            'name_en' => 'Name En',
        ];
    }

    /**
     * Gets query for [[Districts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistricts()
    {
        return $this->hasMany(District::className(), ['region_id' => 'id']);
    }

    /**
     * Get name of region.
     * @return string|null
     */
    public function getName()
    {
//        if (\Yii::$app->language == 'ru'){
//            return '';
//        }
        return $this->name_uz;
    }

    /**
     * @return array
     */
    public static function regions()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name_uz');
    }
}
