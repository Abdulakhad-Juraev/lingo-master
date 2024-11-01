<?php

namespace common\models;

use soft\db\ActiveRecord;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $name
 * @property string|null $info
 * @property int $type
 * @property string $value
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property User $createdBy0
 * @property-read string $typeName
 * @property User $updatedBy0
 */
class Settings extends ActiveRecord
{
    public const TYPE_STRING = 1;
    public const TYPE_INTEGER = 2;
    public const TYPE_FLOAT = 3;
    public const TYPE_BOOLEAN = 4;
    public const TYPE_ARRAY = 5;

    public const BALANCE_PASSWORD = 'balance_password';
    public const PHONE_NUMBER = 'phone_number';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['value'], 'required'],
            ['value', 'customValidate']
        ];
    }

    public function labels(): array
    {
        return [
            'type' => 'Turi',
            'value' => 'Qiymati',
            'info' => "Ma'lumot",
        ];
    }

    public function customValidate($attribute, $params): void
    {
        if ($this->type === self::TYPE_INTEGER) {
            $validator = new \yii\validators\NumberValidator([
                'integerOnly' => true,
                'min' => 0,
                'max' => PHP_INT_MAX
            ]);
            $validator->validateAttribute($this, $attribute);
        }
        if ($this->type === self::TYPE_STRING) {
            $validator = new \yii\validators\StringValidator([
                'max' => 255,
            ]);
            $validator->validateAttribute($this, $attribute);
        }
        if ($this->type === self::TYPE_FLOAT) {
            $validator = new \yii\validators\NumberValidator([
                'integerOnly' => false,
                'min' => 0,
                'max' => PHP_INT_MAX
            ]);
            $validator->validateAttribute($this, $attribute);
        }
        if ($this->type === self::TYPE_BOOLEAN) {
            $validator = new \yii\validators\BooleanValidator();
            $validator->validateAttribute($this, $attribute);
        }
        if ($this->type === self::TYPE_ARRAY) {
            $validator = new \yii\validators\EachValidator([
                'rule' => ['integer']
            ]);
            $validator->validateAttribute($this, $attribute);
        }
    }

    /**
     * @return string[]
     */
    public static function getTypeList(): array
    {
        return [
            self::TYPE_STRING => 'String',
            self::TYPE_INTEGER => 'Integer',
            self::TYPE_FLOAT => 'Float',
            self::TYPE_BOOLEAN => 'Boolean',
            self::TYPE_ARRAY => 'Array',
        ];
    }

    /**
     * @return string
     */
    public function getTypeName(): string
    {
        return self::getTypeList()[$this->type] ?? '';
    }

    /**
     * @throws ServerErrorHttpException
     */
    public static function get(string $name): ?string
    {
        $cache = \Yii::$app->cache;

        return $cache->getOrSet($name, function () use ($name) {
            $setting = self::find()
                ->andWhere([
                    'name' => $name
                ])
                ->one();

            if (!$setting) {
                throw new ServerErrorHttpException("Setting {$name} not found");
            }

            return $setting->value;
        }, 60 * 60 * 24); // Cache for a day
    }

    public static function sharedSettings(): array
    {
        return [
            self::CENTER_LATITUDE,
            self::CENTER_LONGITUDE,
            self::CENTER_RADIUS,
            self::MIN_RUNNING_APP_VERSION,
            self::PHONE_NUMBER
        ];
    }

    /**
     * @return bool
     * @throws ServerErrorHttpException
     */
    public static function isNight(): bool
    {
        $current_hour = (int)date('H');
        $start_hour = (int)Settings::get(Settings::NIGHT_MODE_START);
        $end_hour = (int)Settings::get(Settings::NIGHT_MODE_END);

        if ($start_hour > $end_hour) {
            $isNight = ($current_hour >= $start_hour && $current_hour <= 23) || ($current_hour >= 0 && $current_hour < $end_hour);
        } else {
            $isNight = $current_hour >= $start_hour && $current_hour < $end_hour;
        }

        return $isNight;
    }
}
