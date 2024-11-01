<?php

use common\modules\university\models\Course;
use common\modules\university\models\StatusActiveColumn;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\university\models\search\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Course');
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
            'actionColumn' => [
                'template' => '{view} {update} {delete} {active} ',
                'buttons' => [

                    'active' => function($url, $model, $key) {
                        return StatusActiveColumn::getStatuses($model,'course');
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
    