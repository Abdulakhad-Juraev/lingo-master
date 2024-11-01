<?php
/*
 *  @author Shukurullo Odilov <shukurullo0321@gmail.com>
 *  @link telegram: https://t.me/yii2_dasturchi
 *  @date 21.05.2022, 11:30...
 */

namespace api\models;

use api\modules\ieltsExam\models\IeltsResult;
use api\modules\toefl\models\ToeflResult;
use common\models\UserRefreshTokens;
use common\services\TelegramService;
use Yii;
use yii\web\UploadedFile;

/**
 *
 * @property-read string $imageUrl
 */
class User extends \common\models\User
{

    public function log($message)
    {
        if ($this->log) {
            TelegramService::log($message);
        }
    }


    /**
     * @return string[]
     */
    public function fields()
    {
        return [
            'id',
            'username',
            'full_name',
            'auth_key',
            'type_id',
            'typeName' => function (User $model) {
                return $model->type_id ? $model->typeName() : '';
            },
            'born_date' => function (User $model) {
                return Yii::$app->formatter->asDate($model->born_date, 'php:d.m.Y');
            },
            'regionName' => function (User $model) {
                return $model->region['name_' . Yii::$app->language] ?? '';
            },
            'region_id',
            'districtName' => function (User $model) {
                return $model->district['name_' . Yii::$app->language] ?? '';
            },
            'district_id',
            'sexName' => function (User $model) {
                return $model->sexTypeName();
            },
            'imageUrl' => function (User $model) {
                return $model->getImageUrl();
            },
            'directionName' => function (User $model) {
                return $model->direction->name ?? '';
            },
            'facultyName' => function (User $model) {
                return $model->faculty->name ?? '';
            },
            'courseName' => function (User $model) {
                return $model->course->name ?? '';
            },
            'languageName' => function (User $model) {
                return $model->language->name ?? '';
            },
        ];
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->photo ? Yii::$app->urlManager->hostInfo . '/uploads/user/' . $this->photo : Yii::$app->urlManager->hostInfo . '/template/images/avatar-1.png';
    }

    /**
     * @return string
     */
    public function updateImage()
    {
        $old_img = $this->img;
        $this->img = UploadedFile::getInstanceByName('img');
        $url = Yii::getAlias('@frontend/web/uploads/user/' . $old_img);
        if ($this->img) {
            $this->img->saveAs('@frontend/web/uploads/user/' . 'user' . time() . '.' . $this->img->extension);
            $this->img = 'user' . time() . '.' . $this->img->extension;
            if (is_file($url)) {
                unlink($url);
            }
        } else {
            if (is_file($url)) {
                unlink($url);
            }
        }
    }
    public function getActiveIeltsTest()
    {
        return $this->hasOne(IeltsResult::class, ['user_id' => 'id'])
            ->andWhere(['status' => IeltsResult::STATUS_ACTIVE])
            ->andWhere(['!=', 'step', IeltsResult::STEP_FINISHED]);
    }
    public function getActiveToeflTest()
    {
        return $this->hasOne(ToeflResult::class, ['user_id' => 'id'])
            ->andWhere(['status' => ToeflResult::STATUS_ACTIVE])
            ->andWhere(['!=', 'step', ToeflResult::STEP_FINISHED]);
    }
}
