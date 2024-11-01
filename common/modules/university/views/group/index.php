<?php

use common\modules\university\models\Course;
use common\modules\university\models\Direction;
use common\modules\university\models\Group;
use common\modules\university\models\Language;
use common\modules\university\models\StatusActiveColumn;
use soft\grid\GridView;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\university\models\search\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Group');
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
            'attribute' => 'direction_id',
            'format' => 'raw',
            'filter' => Direction::map(),
            'value' => function (Group $model) {
                return $model->direction ? $model->direction->name : '';
            }
        ],
        [
            'attribute' => 'language_id',
            'format' => 'raw',
            'filter' => Language::map(),
            'value' => function (Group $model) {
                return $model->language ? $model->language->name : '';
            }
        ],
        [
            'attribute' => 'course_id',
            'format' => 'raw',
            'filter' => Course::map(),
            'value' => function (Group $model) {
                return $model->course ? $model->course->name : '';
            }
        ],


        'actionColumn' => [
            'template' => '{view} {update} {active} ',
            'buttons' => [

                'active' => function($url, $model, $key) {
                    return StatusActiveColumn::getStatuses($model,'group');
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
    