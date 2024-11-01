<?php

use common\modules\tariff\models\Tariff;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\tariff\models\search\TariffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tariffs');
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
        'price',
        'duration_number',
        [
            'attribute' => 'duration_text',
            'filter'=>Tariff::durationTexts()
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => 'statusBadge',
            'filter' => Tariff::statuses()
        ],
        //'is_recommend',
        //'created_by',
        //'updated_by',
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
    