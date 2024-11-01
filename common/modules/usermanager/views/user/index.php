<?php


/* @var $this soft\web\View */
/* @var $searchModel StudentSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use soft\helpers\Url;
use soft\helpers\Html;
use soft\grid\GridView;
use common\models\User;
use common\modules\usermanager\models\search\StudentSearch;
use common\modules\university\models\StatusActiveColumn;

$this->title = Yii::t('app', 'User');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
$errors = Yii::$app->session->getFlash('errors');
?>


<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create} ',
    'toolbarButtons' => [

        'create' => false
    ],
    'columns' => [
        [
            'attribute' => 'username',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->username, ['user/view', 'id' => $model->id], ['data-pjax' => 0]);
            }
        ],
        'full_name',
        [
            'attribute' => 'sex',
            'value' => function (User $model) {
                return $model->sexTypeName();
            },
            'filter'=>User::sexTypes()
        ],
        'actionColumn' => [
            'width' => '160px',
            'template' => '{view} {active} ',
            'buttons' => [
                'active' => function ($url, $model, $key) {
                    return StatusActiveColumn::getUserStatuses($model, 'student');
                }
            ],

        ],
    ],
]); ?>
