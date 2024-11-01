<?php

use common\models\Instructions;

/* @var $this soft\web\View */
/* @var $searchModel common\models\search\Instructions */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Instructions');
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
            /** @see soft\widget\button\Button for other configurations */
            'modal' => true,
        ]
    ],
    'columns' => [
        [
            'attribute' => 'content',
            'format' => 'raw',
            'width' => '550px',
        ],
        [
            'attribute' => 'type_id',
            'format' => 'raw',
            'value' => function (Instructions $model) {
                return $model->typeLabel();
            },
            'filter' => Instructions::typesList()
        ], [
            'attribute' => 'exam_type_id',
            'format' => 'raw',
            'value' => function (Instructions $model) {
                return $model->examTypeLabel();
            },
            'filter' => Instructions::examTypesList()
        ],
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
    