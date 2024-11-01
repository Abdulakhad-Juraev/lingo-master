<?php

namespace common\modules\auth\models;

use soft\db\ActiveRecord;
use soft\helpers\ArrayHelper;
use Yii;

/**
 * @property string|null $name
 * @property string|null $description
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $type
 * @property int|null $category_id
 */
class AuthItem extends ActiveRecord
{
    public $id;
    public $category_id;
    const TYPE_ONE = 1;
    const TYPE_TWO = 2;
    const TYPE_THREE = 3;

    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description', 'category_id'], 'string', 'max' => 50],
            [['type'], 'integer'],
            ['name', 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'name' => 'Ролл номи',
            'description' => 'Қисқа тавсиф',
            'category_id' => 'Категория',
        ];
    }

    //</editor-fold>

    /**
     * @return array
     */
    public static function typeOneRules()
    {
        return map(AuthItem::find()->andWhere(['type' => self::TYPE_ONE])->all(), 'name', 'name');
    }

    public static function getChildren($name)
    {
        // Normalize the input name for comparison
        $normalizedName = str_replace(['-', '/'], '', $name) . '/';

        return self::find()
            ->andWhere(['type' => self::TYPE_TWO])
            ->andWhere(['like', 'REPLACE(name, "-", "")', $normalizedName])
            ->andWhere(['REGEXP', 'name', '^' . preg_quote($name, '/')])
            ->all();
    }


}