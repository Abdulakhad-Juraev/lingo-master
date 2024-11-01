<?php

use soft\grid\GridView;
use common\models\User;
use common\modules\usermanager\models\search\UserSearch;

/* @var $this soft\web\View */
/* @var $searchModel UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app', 'System Users');
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
            'content' => t('Create a new'),
            'icon' => 'user-plus,fas'
        ]
    ],
    'columns' => [
        'username',
        'firstname',
        'lastname',
        [
            'attribute' => 'status',
            'filter' => User::statuses(),
            'format' => 'raw',
            'value' => function (User $model) {
                return $model->statusBadge;
            }
        ],
        'created_at',
        'actionColumn' => [
            'width' => '160px',
            'template' => '{view} {update}',
        ],
    ],
]); ?>
    