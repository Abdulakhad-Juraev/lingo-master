<?php

use common\modules\ieltsExam\models\IeltsQuestionGroup;
use common\modules\ieltsExam\models\IeltsQuestions;
use soft\grid\GridView;
use soft\widget\bs4\TabMenu;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\ieltsExam\models\search\IeltsQuestionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'IELTS Writing Questions');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= $this->render('@common/views/menu/_tab-menu-ielts', ['model' => $model]) ?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => false,
            'url' => ['ielts-questions-writing/create', 'id' => $model->id, ['data-pjax' => 0]],
        ]
    ],
    'columns' => [
        'info',
        [
            'attribute' => 'section',
            'value' => function (IeltsQuestions $model) {
                return $model->sectionName() ?? '-';
            },
            'filter' => IeltsQuestions::sections()
        ],
        'actionColumn' => [
            'template' => '{view} {update} {delete} ',
            'viewOptions' => [],
            'updateOptions' => [],
        ],
    ],
]); ?>
    