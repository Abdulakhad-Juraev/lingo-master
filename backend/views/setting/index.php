<?php

use common\models\Setting;

/* @var $this soft\web\View */
/* @var $searchModel common\models\search\SettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}',
    'columns' => [
        'company_name',
        [
            'attribute' => 'img',
            'format' => 'raw',
            'value' => function (Setting $model) {
                return \soft\helpers\Html::img('/uploads/background/'.$model->img,['style'=>'width:120px;height:auto']);
            }
        ],
        //'created_at',
        //'updated_at',
        'actionColumn' => [
            'template' => '{update}',
            'viewOptions' => [
                'role' => 'modal-remote',
            ],
            'updateOptions' => [
                'role' => 'modal-remote',
            ],
        ],
    ],
]); ?>
    