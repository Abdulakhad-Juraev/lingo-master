<?php

use common\modules\university\models\Department;
use common\modules\university\models\Faculty;
use common\modules\university\models\StatusActiveColumn;
use soft\grid\GridView;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\university\models\search\DepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Department');
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
            'modal' => true,
        ]
    ],
    'columns' => [
        'name',
        [
            'attribute' => 'faculty_id',
            'format' => 'raw',
            'filter' => Faculty::map(),
            'value' => function (Department $model) {
                return $model->faculty ? $model->faculty->name : '';
            }
        ],
        'actionColumn' => [
            'template' => '{view} {update} {delete} {active} ',
            'buttons' => [

                'active' => function($url, $model, $key) {
                    return StatusActiveColumn::getStatuses($model,'department');
                }
            ],
            'viewOptions' => [
                'role' => 'modal-remote',
            ],
            'updateOptions' => [
                'role' => 'modal-remote',
            ],
        ],
    ],
]); ?>
    