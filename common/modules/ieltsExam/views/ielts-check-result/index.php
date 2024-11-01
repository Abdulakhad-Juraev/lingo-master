<?php

use common\models\User;
use common\modules\ieltsExam\models\IeltsResult;
use soft\grid\GridView;
use soft\helpers\ArrayHelper;
use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\ieltsExam\models\search\IeltsResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ielts Results');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{refresh}',
    'toolbarButtons' => [
        'create' => false
    ],
    'columns' => [
        [
            'attribute' => 'user_id',
            'label' => t('User'),
            'format' => 'raw',
            'value' => function (IeltsResult $model) {
                return \yii\helpers\Html::a($model->user->full_name, ['detail', 'id' => $model->id], ['data-pjax' => '0']);
            },
            'filter' => ArrayHelper::map(
                User::find()
                    ->andWhere(['status' => User::STATUS_ACTIVE])
                    ->all(),
                'id',
                'fullName'
            )
        ],
        [
            'attribute' => 'exam_id',
            'value' => function (IeltsResult $model) {
                return $model->exam->title;
            },
        ],
        'listening_score',
        'reading_score',
        'writing_score',
        'speaking_score',
//        [
//            'attribute' => 'badeScore',
//            'width' => '100px',
//            'value' => function (IeltsResult $model) {
//                return $model->getIeltsBandScore();
//            },
//            'contentOptions' => ['style' => 'text-align: center;'],
//            'headerOptions' => ['style' => 'text-align: center;']
//        ],
        [
            'attribute' => 'started_at',
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
                return date('d.m.Y H:i', $model->started_at);
            },
        ],
        [
            'attribute' => 'finished_at',
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
//        'actionColumn' => [
//            'template' => '{grade-speaking} {grade-writing}',
//            'buttons' => [
//                'grade-speaking' => function ($url, $key, $model) {
//                    return Html::a('<i class="fa fa-volume-up"></i>', $url, ['role' => 'modal-remote']);
//                },
//                'grade-writing' => function ($url, $key, $model) {
//                    return Html::a('<i class="fa fa-book"></i>', $url, ['role' => 'modal-remote']);
//                },
//            ],
//            'visibleButtons' => [
//                'grade-speaking' => function (IeltsResult $model) {
//                    return !$model->speaking_score;
//                },
//                'grade-writing' => function (IeltsResult $model) {
//                    return !$model->writing_score;
//                },
//            ],
//        ],
    ],
]); ?>
