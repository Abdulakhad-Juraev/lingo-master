<?php

use common\models\User;
use common\modules\testmanager\models\Test;
use common\modules\testmanager\models\TestEnroll;
use soft\grid\GridView;
use soft\helpers\ArrayHelper;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\testmanager\models\search\TestEnrollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Test Sale');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= GridView::widget([
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
            'attribute' => 'test_id',
            'value' => function (TestEnroll $model) {
                return $model->test->name;
            },
            'width' => '200px',
            'filter' => Test::paymetMap(),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => ''],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        [
            'attribute' => 'user_id',
            'value' => function (TestEnroll $model) {
                return $model->user->full_name;
            },
            'width' => '250px',
            'filter' => User::map(),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => ''],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],

        [
            'attribute' => 'payment_type_id',
            'value' => function (TestEnroll $model) {
                return $model->paymentTypeName();
            },
            'width' => '250px',
            'filter' => TestEnroll::adminPaymentTypes(),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => ''],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        'price',
        'count',
        'actionColumn' => [
            'viewOptions' => [
                'role' => 'modal-remote',
            ],
            'updateOptions' => [
                'role' => 'modal-remote',
            ],
        ],
    ],
]); ?>
    