<?php

use common\modules\ieltsExam\models\IeltsResult;
use soft\grid\GridView;
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
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => false
    ],
    'columns' => [
        [
            'attribute' => 'user_id',
            'label' => t('User'),
            'value' => function (IeltsResult $model) {
                return $model->user->full_name;
            },
        ],
        [
            'attribute' => 'exam_id',
            'format' => 'raw',
            'value' => function (IeltsResult $model) {
                return Html::a($model->exam->title, ['ielts-result-item/index', 'result_id' => $model->id]);
            },
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
                return date('d.m.Y H:i:s', $model->finished_at);
            },
        ],
        'listening_score',
        'reading_score',
        'writing_score',
        'speaking_score',
        [
            'attribute' => 'badeScore',
            'width' => '100px',
            'value' => function (IeltsResult $model) {
                return $model->getIeltsBandScore();
            },
            'contentOptions' => ['style' => 'text-align: center;'],
            'headerOptions' => ['style' => 'text-align: center;']
        ],

    ],
]); ?>
    