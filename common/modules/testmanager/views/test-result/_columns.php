<?php

use common\modules\testmanager\models\Test;
use common\modules\testmanager\models\TestResult;
use common\modules\university\models\Course;
use common\modules\university\models\Faculty;
use soft\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $searchModel common\modules\testmanager\models\search\TestResultSearch */


$subjectsMap = ArrayHelper::map(Test::find()->asArray()->all(), 'id', 'name');
$facultyMap = ArrayHelper::map(Faculty::find()->all(), 'id', function (Faculty $model) {
    return $model['name_' . Yii::$app->language];
});

$courseMap = ArrayHelper::map(Course::find()->all(), 'id', function (Course $model) {
    return $model['name_' . Yii::$app->language];
});

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'userFullName',
        'label' => t('User'),
        'format' => 'raw',
        'value' => function ($model) {
            return Html::a($model->user->full_name ?? 'User', ['view', 'id' => $model->id], ['data-pjax' => 0]);
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'faculty_id',
        'value' => function (TestResult $model) {
            return $model->user->faculty['name_' . Yii::$app->language] ?? '';
        },
        'filter' => $facultyMap,
        'label' => Yii::t('app', 'Faculty'),
        'hAlign' => 'center'
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'course_id',
        'value' => function (TestResult $model) {
            return $model->user->course['name_' . Yii::$app->language] ?? '';
        },
        'filter' => $courseMap,
        'label' => Yii::t('app', 'Course'),
        'hAlign' => 'center'
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'test_id',
        'value' => 'test.name',
        'filter' => $subjectsMap,
        'label' => Yii::t('app', 'Test'),
        'hAlign' => 'center'

    ],

    [
        'attribute' => 'price',
        'value' => 'priceText',
        'format' => 'raw',
        'label' => Yii::t('app', 'Cost'),
        'filter' => [
            2 => Yii::t('app', 'Free'),
            1 => Yii::t('app', 'Paid')
        ],
        'hAlign' => 'center'

    ],
    [
        'attribute' => 'started_at',
        'filterType' => GridView::FILTER_DATE_RANGE,
        'hAlign' => 'center',
        'filterWidgetOptions' => [
            'model' => $searchModel,
            'convertFormat' => true,
            'presetDropdown' => true,
            'includeMonthsFilter' => true,
            'pluginOptions' => [
                'locale' => [
                    'format' => 'Y-m-d'
                ]
            ]
        ],
        'value' => function ($model) {
            return date('d.m.Y H:i', $model->started_at);
        },
    ],
    [
        'attribute' => 'finished_at',
        'hAlign' => 'center',
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => [
            'model' => $searchModel,
            'convertFormat' => true,
            'presetDropdown' => true,
            'includeMonthsFilter' => true,
            'pluginOptions' => [
                'locale' => [
                    'format' => 'Y-m-d'
                ]
            ]
        ],
        'value' => function ($model) {
            return date('d.m.Y H:i', $model->finished_at);
        },
    ],
//    [
//        'attribute' => 'started_at',
//        'value' => 'formattedStartedTime',
//        'filter' => false,
//        'hAlign' => 'center'
//
//    ],
//    [
//        'attribute' => 'finished_at',
//        'value' => 'formattedFinishedTime',
//        'filter' => false,
//        'hAlign' => 'center'
//
//    ],
    [
        'attribute' => 'tests_count',
        'filter' => false,
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'correct_answers',
        'filter' => false,
        'hAlign' => 'center'
    ],
    [
        'attribute' => 'formattedPercent',
        'label' => t('Percentage'),
        'filter' => false,
        'hAlign' => 'center'
    ],
];   