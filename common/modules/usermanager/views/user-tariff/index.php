<?php

use common\models\User;
use common\modules\usermanager\models\UserTariff;
use soft\grid\GridView;
use soft\widget\kartik\Select2;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\usermanager\models\search\UserTariffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Tariffs');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => true,
        ]
    ],
    'columns' => [
        [
            'attribute' => 'user_id',
            'value' => function (UserTariff $model) {
                return $model->user->full_name;
            },
            'width' => '200px',

            'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'user_id',
                'data' => User::map(), // Adjust this to match your User model's map method
                'options' => [
                    'placeholder' => 'Select a user...',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]),
        ],
        [
            'attribute' => 'tariff_id',
            'value' => function (UserTariff $model) {
                return $model->tariff->name;
            },
            'filter' => \common\modules\tariff\models\Tariff::map()
        ],
        'price:sum',
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
            'attribute' => 'expired_at',
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
                return date('d.m.Y H:i', $model->expired_at);
            },
        ],
        'actionColumn' => [
            'template' => '{delete}'
        ],
    ],
]); ?>
    