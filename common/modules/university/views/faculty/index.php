<?php

use common\modules\university\models\Faculty;
use common\modules\university\models\StatusActiveColumn;
use soft\db\ActiveRecord;
use soft\grid\GridView;
use soft\grid\StatusColumn;
use soft\helpers\Html;
use soft\helpers\Url;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\university\models\search\FacultySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app', 'Faculty');
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
        'actionColumn' => [
            'template' => '{view} {update} {active} ',
            'buttons' => [

                'active' => function($url, $model, $key) {
                     return StatusActiveColumn::getStatuses($model,'faculty');
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
    