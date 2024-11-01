<?php

use soft\grid\GridView;
use common\modules\usermanager\models\UserDevice;
use common\modules\university\models\StatusActiveColumn;
use common\modules\usermanager\models\search\UserDeviceSearch;

/* @var $model UserDevice */
/* @var $this soft\web\View */
/* @var $searchModel UserDeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = t('User Device');
$this->params['breadcrumbs'][] = ['label' => t('Student'), 'url' => ['index']];
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
        'device_name',
        'device_id',
        'actionColumn' => [
            'width' => '160px',
            'template' => '{view} {delete} {active} ',
            'buttons' => [
                'active' => function ($url, $model, $key) {
                    return StatusActiveColumn::getStatuses($model, 'user-device');
                }
            ],
            'controller' => 'user-device',
            'viewOptions' => [
                'role' => 'modal-remote',
            ],
            'updateOptions' => [
                'role' => 'modal-remote',
            ],
        ],
    ],
]); ?>
