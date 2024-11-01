<?php

namespace common\models;

use soft\behaviors\UploadBehavior;
use Yii;

/**
 * This is the model class for table "company_info".
 *
 * @property int $id
 * @property string|null $logo
 * @property string|null $instagram
 * @property string|null $telegram
 * @property string|null $twitter
 * @property string|null $youtube
 * @property string|null $facebook
 * @property int|null $status
 */
class CompanyInfo extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['instagram', 'telegram', 'twitter', 'youtube', 'facebook'], 'string', 'max' => 255],

            ['logo', 'file', 'extensions' => 'png, jpg, svg'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::class,
                'attribute' => 'logo',
                'scenarios' => ['default'],
                'path' => '@frontend/web/uploads/company-info/{id}',
                'url' => '/uploads/company-info/{id}',
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'id' => 'ID',
            'logo' => 'Logo',
            'instagram' => 'Instagram',
            'telegram' => 'Telegram',
            'twitter' => 'Twitter',
            'youtube' => 'Youtube',
            'facebook' => 'Facebook',
            'status' => Yii::t('app', 'Status'),
        ];
    }


    public function getFileUrl($type = "thumb")
    {
        return Yii::$app->urlManager->hostInfo . '/uploads/company-info' . '/' . $this->id . '/' . $this->logo;
    }
    //</editor-fold>

}
