<?php

use common\modules\testmanager\models\search\TestSearch;
use common\modules\testmanager\models\Test;
use soft\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Test');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbarTemplate' => '{create}{refresh}',
        'columns' => [
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var  $model */
                    return Html::a($model->name, ['question/index', 'test_id' => $model->id], ['data-pjax' => 0]);
                }
            ],
            'is_free:boolean',
            'price:integer',
            'tests_count',
            'duration',
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
            [
                'attribute' => 'status',
                'filter' => [
                    1 => Yii::t('app', 'Active'),
                    0 => Yii::t('app', 'Inactive'),
                ],
                'value' => function (Test $model) {
                    return $model->status ? Yii::t('app', 'Active') : Yii::t('app', 'Inactive');
                }
            ],
            'show_answer:boolean',
            [
                'class' => 'soft\grid\ActionColumn',
                'template' => '{view} {update} {delete} {import} {export}',
                'buttons' => [
                    'import' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-download"></i>', $url);
                    },
                    'export' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-upload"></i>', $url,['data-pjax'=>'0']);
                    }
                ],
            ],
        ],
    ]); ?>

</div>

