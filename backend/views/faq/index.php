<?php

use common\models\Faq;

/* @var $this soft\web\View */
/* @var $searchModel common\models\search\FaqSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Faqs');
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
            'modal' => false,
        ]
    ],
    'columns' => [
        'question',
        'answer',
        'sort_order',
        'statusBadge:raw',
        'actionColumn' => [
            'viewOptions' => [
//                'role' => 'modal-remote',
            ],
            'updateOptions' => [
//                'role' => 'modal-remote',
            ],
        ],
    ],
]); ?>
    