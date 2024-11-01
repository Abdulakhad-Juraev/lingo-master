<?php

use common\models\TestList;
use soft\grid\GridView;
use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\search\TestListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Test Lists');
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
            'modal' => false,
        ]
    ],
    'columns' => [
        'name',
        'title',
        'description',
        [
            'attribute' => 'image',
            'format' => 'raw',
            'value' => function (TestList $list) {
                return Html::img($list->getImageUrl(),['style'=>'width:150px;object-fit:cover']);
            }
        ],
        'statusBadge:raw',
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
    