<?php


/* @var $model TestResult */
/* @var $this soft\web\View */
/* @var $searchModel TestResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\modules\testmanager\models\TestResult;
use soft\grid\GridView;
use common\modules\testmanager\models\search\TestResultSearch;

$this->title = Yii::t('app', 'Test Result');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->full_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= $this->render('_tab-menu', ['model' => $model]) ?>
<?= GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => false,
    'toolbarButtons' => false,
    'columns' => [
        [
            'attribute' => 'test_id',
            'label'=>t('Test'),
            'format'=>'raw',
            'value' => function ($model) {
                return $model->test ? $model->test->name : '';
            }
        ],

        'duration',
        'tests_count',
        'correct_answers',

        'actionColumn' => [
            'template' => false,
            'buttons' => false
        ],
    ],
]); ?>
