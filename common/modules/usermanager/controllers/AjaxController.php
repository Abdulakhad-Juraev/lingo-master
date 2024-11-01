<?php

namespace common\modules\usermanager\controllers;

use common\modules\region\models\Districts;
use common\modules\regionmanager\models\District;
use common\modules\university\models\Department;
use common\modules\university\models\Direction;
use common\modules\university\models\Group;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * Site controller
 */
class AjaxController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionSubcat()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $menyu_id = $parents[0];
                $out = self::getList($menyu_id);

                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionDirection()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $menyu_id = $parents[0];
                $out = self::getDirectionList($menyu_id);

                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }
    public function actionGroup()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $menyu_id = $parents[0];
                $out = self::getGroupList($menyu_id);

                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

//    /**
//     * @return array|string[]
//     * Shahar | Tuman ma'lumotlarini olish uchun
//     */
//    public function actionDirection()
//    {
//        Yii::$app->response->format = Response::FORMAT_JSON;
//
//        $out = [];
//
//        if (isset($_POST['depdrop_parents'])) {
//
//            $parents = $_POST['depdrop_parents'];
//
//            if ($parents != null) {
//
//                $facultyId = $parents[0];
//
//                $out = Direction::getDirections($facultyId);
//
//                return ['output' => $out, 'selected' => ''];
//            }
//        }
//        return ['output' => '', 'selected' => ''];
//    }
//
//    /**
//     * @param $regionId
//     * @return array
//     * FacultyId - ga tegishli  ma'lumotlarni olib beradi
//     */
//    public static function getDirection($facultyId)
//    {
//        $arr = [];
//        foreach (Direction::find()->andWhere(['faculty_id' => $facultyId])->active()->all() as $k) {
//
//            $arr[] = ["id" => $k['id'], "name" => $k['name_uz']];
//        }
//        return $arr;
//    }
//
//    /**
//     * @return array|string[]
//     * Tuman yoki Shaharga tegishli ma'lumotlarni olib beradi
//     */
//    public function actionGroup()
//    {
//        Yii::$app->response->format = Response::FORMAT_JSON;
//
//        $out = [];
//
//        if (isset($_POST['depdrop_parents'])) {
//
//            $parents = $_POST['depdrop_parents'];
//
//            if ($parents != null) {
//
//                $directionId = $parents[1];
//
//                $out = self::getGroups($directionId);
//
//                return ['output' => $out, 'selected' => ''];
//            }
//        }
//        return ['output' => '', 'selected' => ''];
//    }

//    /**
//     * @param $districtId
//     * @return array
//     * $districtId - ga tegishli  mahallalarni olib beradi
//     */
//    public static function getGroups($directionId)
//    {
//        $arr = [];
//
//        foreach (Group::find()->andWhere(['direction_id' => $directionId])->active()->all() as $k) {
//            $arr[] = ["id" => $k['id'], "name" => $k->name];
//        }
//        return $arr;
//    }

    public function actionDistricts()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $menyu_id = $parents[0];
                $out = self::getDistrictList($menyu_id);

                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function getDirectionList($menyu_id)
    {
        $arr = [];
        foreach (Direction::find()->where(['faculty_id' => $menyu_id])->all() as $k) {
            $arr[] = ["id" => $k['id'], "name" => $k['name_uz']];
        }
        return $arr;
    }

    public function getList($menyu_id)
    {
        $arr = [];
        foreach (Department::find()->where(['faculty_id' => $menyu_id])->all() as $k) {
            $arr[] = ["id" => $k['id'], "name" => $k['name']];
        }
        return $arr;
    }

    public function getDistrictList($menyu_id): array
    {
        $arr = [];
        foreach (District::find()->where(['region_id' => $menyu_id])->all() as $k) {
            $arr[] = ["id" => $k['id'], "name" => $k['name_uz']];
        }
        return $arr;
    }
    public function getGroupList($menyu_id): array
    {
        $arr = [];
        foreach (Group::find()->where(['direction_id' => $menyu_id])->all() as $k) {
            $arr[] = ["id" => $k['id'], "name" => $k['name_uz']];
        }
        return $arr;
    }
}