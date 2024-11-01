<?php

namespace backend\modules\profilemanager\models;

use common\models\User;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Yii;
use yii\helpers\FileHelper;

class ProfileUser extends User
{

    const SCENARIO_UPDATE = 'update';
    const SCENARIO_CHANGE_PASSWORD = 'change_password';

    public function rules()
    {
        return [
            [['username', 'firstname'], 'required'],
            ['username', 'unique'],
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['username', 'lastname', 'firstname'], 'string', 'max' => 255],

        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => "Login",
            'firstname' => "Ism",
            'lastname' => "Familiya",
            'image' => 'Rasm'
        ];
    }

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE] = ['username', 'firstname', 'lastname','photo'];
        $scenarios[self::SCENARIO_CHANGE_PASSWORD] = ['password_hash'];
        return $scenarios;
    }

    /**
     * @return \backend\modules\profilemanager\models\ProfileUser|false
     */
    public static function getUserModel()
    {
        $model = static::findOne(Yii::$app->user->getId());
        if ($model == null) {
            return false;
        }

        $model->scenario = self::SCENARIO_UPDATE;
        return $model;
    }
    public function upload(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $imageName = \Yii::$app->security->generateRandomString(16) . "." . $this->photo->extension;

        if (FileHelper::createDirectory(\Yii::getAlias("@frontend/web/uploads/user")) && $this->photo->saveAs("@frontend/web/uploads/user/" . $imageName)) {

            //Delete old image if exists
            $oldImagePath = \Yii::getAlias("@frontend/web/uploads/user") . '/' . pathinfo($this->photo)['basename'];
            if (is_file($oldImagePath) && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            if ($this->photo->extension !== 'svg') {
                [$width, $height] = getimagesize(\Yii::getAlias("@frontend/web/uploads/user") . '/' . $imageName);
                $minValue = min($width, $height);

                $imagine = new Imagine();
                $image = $imagine->open(\Yii::getAlias("@frontend/web/uploads/user") . '/' . $imageName);
                $image->crop(new Point(0, 0), new Box($minValue, $minValue))->resize(new Box(500, 500))->save(\Yii::getAlias("@frontend/web/uploads/user") . '/' . $imageName, [
                    'jpeg_quality' => 50
                ]);
            }
            $this->photo = $imageName;
            return $this->save();
        }

        return false;
    }

    public function resetAvatar(): bool
    {
        $oldImagePath = \Yii::getAlias("@frontend/web/uploads/user") . '/' . pathinfo($this->photo->image)['basename'];

        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }

        $this->user->photo = '';
        return $this->user->save();
    }
}