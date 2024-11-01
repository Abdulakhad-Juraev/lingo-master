<?php

use common\modules\regionmanager\models\District;
use common\modules\regionmanager\models\Region;
use common\modules\regionmanager\models\search\DistrictSearch;

/* @var $this soft\web\View */
/* @var $region Region */
/* @var $searchModel DistrictSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = t('District');
$this->params['breadcrumbs'][] = t('District');
$this->registerAjaxCrudAssets();
?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'panel' => [
        'before' => t('District'),
    ],
//        'toolbarTemplate' => '{create}{refresh}',
    'toolbarTemplate' => false,
//        'toolbarButtons' => [
//            'create' => [
//                /** @see soft\widget\button\Button for other configurations */
//                'modal' => true,
//            ]
//        ],
//    'bulkButtonsTemplate' => '{delete}',
//    'bulkButtons' => [
//        'delete' => [
//            /** @see soft\widget\button\BulkButton for other configurations */
//        ],
//    ],
    'columns' => [
        [
            'attribute' => 'region_id',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var District $model */
                return $model->region->name;
            }
        ],
        [
            'attribute' => 'name_uz',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var District $model */
                return $model->name;
            }
        ],
        [
            'attribute' => 'name_en',
            'format' => 'raw',
            'value' => function ($model) {
                /** @var District $model */
                return $model->name_en;
            }
        ],
        'name_ru',
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
    