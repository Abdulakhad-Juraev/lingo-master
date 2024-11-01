<?php

use common\modules\university\models\Direction;
use common\modules\university\models\Faculty;
use common\modules\university\models\StatusActiveColumn;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\university\models\search\DirectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Direction');
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
        'name',
        [
            'attribute' => 'faculty_id',
            'format' => 'raw',
            'filter' => Faculty::map(),
            'value' => function (Direction $model) {
                return $model->faculty ? $model->faculty->name : '';
            }
        ],
        'actionColumn' => [
            'template' => '{view} {update} {delete} {active} ',
            'buttons' => [

                'active' => function($url, $model, $key) {
                    return StatusActiveColumn::getStatuses($model,'direction');
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
    