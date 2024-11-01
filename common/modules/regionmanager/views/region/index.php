<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 13.07.2021, 15:18
 */

use backend\modules\regionmanager\models\Region;

/* @var $this soft\web\View */
/* @var $searchModel backend\modules\regionmanager\models\search\RegionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = t('Regions');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'panel' => [
        'before' => t('Regions'),
    ],
    'toolbarTemplate' => false,
    'columns' => [
        'name_uz',
        'name_en',
        'name_ru',
//        'actionColumn' => [
//            'viewOptions' => [
//                'role' => 'modal-remote',
//            ],
//            'updateOptions' => [
//                'role' => 'modal-remote',
//            ],
//        ],
    ],
]); ?>
    