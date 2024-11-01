<?php


use common\modules\usermanager\models\search\UserPaymentSearch;
use common\modules\usermanager\models\UserPayment;
use common\traits\RangeFilterable;
use soft\grid\GridView;

/* @var $this soft\web\View */
/* @var $searchModel UserPaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\modules\usermanager\models\Student */

$this->title = Yii::t('app', 'User payments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->full_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= $this->render('_tab-menu', ['model' => $model]) ?>
<?= GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => false,
    'toolbarButtons' => false,
    'columns' => [
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
            'width' => '350px',
            'filter' => RangeFilterable::getFilter($searchModel),
        ],
        [
            'attribute' => 'type_id',
            'format' => 'raw',
            'filter' => UserPayment::paymentTypes(),
            'value' => function ($model) {
                return $model->paymentTypeName() ? $model->paymentTypeName() : '';
            },
        ],
        [
            'attribute' => 'value',
            'format' => 'raw',
            'width' => '350px',
            'value' => function ($model) {
                return $model->value;
            },
        ],
        'actionColumn' => [
            'template' => false,
        ],
    ],
]); ?>
