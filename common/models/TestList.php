<?php

namespace common\models;

use odilov\multilingual\behaviors\MultilingualBehavior;
use soft\behaviors\UploadBehavior;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "test_list".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $title
 * @property string|null $description
 * @property string|null $image
 * @property int|null $status
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class TestList extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'test_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'title', 'description'], 'required'],
            [['status', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['name', 'title', 'description'], 'string', 'max' => 255],
            ['image', 'file', 'extensions' => 'png, jpg, svg'],

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
                'attributes' => ['title', 'name', 'description'],
                'languages' => $this->languages(),
            ],
            [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'scenarios' => ['default'],
                'path' => '@frontend/web/uploads/test-list/{id}',
                'url' => '/uploads/test-list/{id}',
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
            'name' => t('Name'),
            'title' => t('Title'),
            'description' => t('Description'),
            'image' => 'Image',
        ];
    }

    public function getImageUrl($type = "thumb")
    {
        return Yii::$app->urlManager->hostInfo . '/uploads/test-list' . '/' . $this->id . '/' . $this->image;
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">


    public function getCreatedBy(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }


    public function getUpdatedBy(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }


    //</editor-fold>
}
