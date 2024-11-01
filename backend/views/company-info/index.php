<?php

use common\models\CompanyInfo;
use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\models\search\CompanyInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Company Info');
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
        [
            'attribute' => 'logo',
            'format' => 'raw',
            'value' => function (CompanyInfo $model) {
                return Html::img($model->getFileUrl(),['style'=>'width:150px;object-fit:cover']);
            }
        ],
        'instagram',
        'telegram',
        'twitter',
        'youtube',
        'facebook',
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
    