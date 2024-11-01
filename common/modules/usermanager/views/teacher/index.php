<?php


/* @var $this soft\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */


use common\modules\university\models\StatusActiveColumn;
use soft\grid\GridView;
use soft\helpers\PhoneHelper;


$this->title =  t('Teachers');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}',
    'toolbarButtons' => [
        'create' => [
            'modal' => false,
            'pjax' => false,
            'cssClass' => 'btn btn-info',
            'content' => t( 'Create a new'),
            'icon' => 'user-plus,fas'
        ]
    ],
    'columns' => [

        [
            'attribute' => 'username',
            'format' => 'raw',
            'value' => function ($model) {
                return "+998 " . PhoneHelper::formatPhoneNumber($model->username);
            },
        ],
        'firstname',
        'lastname',
        'created_at',
        'actionColumn' => [
            'width' => '160px',
            'template' => '{view} {update} {delete} {active} ',
            'buttons' => [
                'active' => function ($url, $model, $key) {
                    return StatusActiveColumn::getUserStatuses($model, 'teacher');
                }
            ],
        ],
    ],
]); ?>
    