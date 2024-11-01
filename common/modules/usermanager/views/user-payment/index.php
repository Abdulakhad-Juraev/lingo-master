<?php

use common\modules\usermanager\models\User;
use common\modules\usermanager\models\UserPayment;
use soft\grid\GridView;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\usermanager\models\search\UserPaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User payments');
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
//        'id',
        [
            'attribute' => 'user_id',
            'value' => function (UserPayment $model) {
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
        'amount',
        [
            'attribute' => 'type_id',
            'value' => function (UserPayment $model) {
                return $model->paymentTypeName();
            },
            'width' => '250px',
            'filter' => UserPayment::paymentTypes(),
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => ''],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        'comment',
        //'transaction_id',
        //'created_by',
        //'updated_by',
//        'created_at',
        //'updated_at',

    ],
]); ?>
    