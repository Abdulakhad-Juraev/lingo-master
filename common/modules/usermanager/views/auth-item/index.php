<?php

use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auth Items';
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => true,
        ]
    ],
//        'bulkButtonsTemplate' => '{delete}',
//        'bulkButtons' => [
//            'delete' => [
//                /** @see soft\widget\button\BulkButton for other configurations */
//            ],
//        ],
    'cols' => [
        'name',
        'type',
        'created_at',
//        'description:ntext',
//        'rule_name',
//        'data',
        //'created_at',
        //'updated_at',
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
    