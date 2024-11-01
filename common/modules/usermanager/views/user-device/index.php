<?php

use common\modules\usermanager\models\UserDevice;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\usermanager\models\search\UserDeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Devices');
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

                'modal' => true,
            ]
        ],
        'columns' => [
                    'id',
            'user_id',
            'device_name',
            'device_id',
            'firebase_token:ntext',

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
    