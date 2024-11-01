<?php

use common\modules\auth\models\search\AuthItemSearch;
use soft\grid\GridView;

/* @var $this soft\web\View */
/* @var $searchModel AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Permission');
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
            'visible' => canRoles(['admin']),
        ]
    ],
    'columns' => [
        'name',
        'description',
        'actionColumn' => [
            'template' => '{view} {update}',
            'viewOptions' => [
                'role' => 'modal-remote',
            ],
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return a('<i class="fas fa-edit"></i>', ['/auth-manager/permission/update', 'name' => $model->name], ['data-pjax' => '0']);
                },
                'view' => function ($url, $model, $key) {
                    return a('<i class="fas fa-eye"></i>', ['/auth-manager/permission/view', 'name' => $model->name]);
                },
//                'delete' => function ($url, $model) {
//                    return a('<i class="fas fa-trash-alt"></i>', ['/auth-manager/permission/delete', 'name' => $model->name], [
//                        'title' => Yii::t('site', 'Delete'),
//                        'data-confirm' => Yii::t('site', 'Are you sure you want to delete?'),
//                        'data-method' => 'post', 'data-pjax' => '0',
//                    ]);
//                }
            ]
        ],
    ],
]); ?>
