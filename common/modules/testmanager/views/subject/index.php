<?php

use common\modules\testmanager\models\Subject;
use common\modules\university\models\StatusActiveColumn;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\testmanager\models\search\SubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Subjects');
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
        'name',
        'actionColumn' => [
            'template' => '{view} {update} {delete} {active} ',
            'buttons' => [

                'active' => function ($url, $model, $key) {
                    return StatusActiveColumn::getStatuses($model, 'subject');
                }
            ],

        ],
    ],
]); ?>
    