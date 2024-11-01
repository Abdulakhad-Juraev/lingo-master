<?php

namespace api\controllers;


use api\models\CompanyInfo;
use api\models\Course;
use api\models\Direction;
use api\models\District;
use api\models\Faculty;
use api\models\Faq;
use api\models\Language;
use api\models\TestList;
use common\models\UniversityStatistics;
use common\models\User;
use common\modules\regionmanager\models\Region;

class OpenDataListController extends ApiBaseController
{
    public $authRequired = false;

    public function actionFacultyList(): array
    {
        Faculty::setFields([
            'id',
            'name' => function (Faculty $model) {
                return $model->name;
            }
        ]);
        return $this->success(Faculty::find()
            ->andWhere(['status' => Faculty::STATUS_ACTIVE])
            ->all());
    }

    public function actionDirectionList(): array
    {
        Direction::setFields([
            'id',
            'name' => function (Direction $model) {
                return $model->name;
            }
        ]);
        return $this->success(Direction::find()
            ->andWhere(['status' => Direction::STATUS_ACTIVE])
            ->all());
    }

    public function actionCourseList(): array
    {
        Course::setFields([
            'id',
            'name' => function (Course $model) {
                return $model->name;
            }
        ]);
        return $this->success(Course::find()
            ->andWhere(['status' => Course::STATUS_ACTIVE])
            ->all());
    }

    public function actionLanguageList(): array
    {
        Language::setFields([
            'id',
            'name' => function (Language $model) {
                return $model->name;
            }
        ]);
        return $this->success(Language::find()
            ->andWhere(['status' => Language::STATUS_ACTIVE])
            ->all());
    }


    public function actionRegionList(): array
    {
        Region::setFields([
            'id',
            'name' => function (Region $model) {
                return $model->name_uz;
            }
        ]);
        return $this->success(Region::find()
            ->all());
    }

    public function actionDistrictList(): array
    {
        District::setFields([
            'id',
            'name' => function (District $model) {
                return $model->name_uz;
            },
            'region_id',
        ]);

        return $this->success(District::find()
            ->all());
    }

    public function actionSexList(): array
    {
        $array = [];
        foreach (User::sexTypes() as $key => $sexType) {
            $array[] = [
                'id' => $key,
                'name' => $sexType
            ];
        }
        return $this->success($array);
    }


}