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
class AuthItemThree extends ActiveRecord
{
    public $id;
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
            [['name', 'description'], 'string', 'max' => 50],
            [['type', 'id'], 'integer'],
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
            'name' => 'Пермиссион  номи',
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
        return map(AuthItem::find()->andWhere(['type' => self::TYPE_ONE])->all(), 'name', 'description');
    }

    /**
     * Creates and populates a set of models.
     *
     * @param string $modelClass
     * @param array $multipleModels
     * @return array
     */
    public static function createMultiple($modelClass, $multipleModels = [])
    {
        $model = new $modelClass;
        $formName = $model->formName();
        $post = Yii::$app->request->post($formName);
        $models = [];

        if (!empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'name', 'name'));
            $multipleModels = array_combine($keys, $multipleModels);
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if (isset($item['name']) && !empty($item['name']) && isset($multipleModels[$item['name']])) {
                    $models[] = $multipleModels[$item['name']];
                } else {
                    $models[] = new $modelClass;
                }
            }
        }

        unset($model, $formName, $post);

        return $models;
    }
}