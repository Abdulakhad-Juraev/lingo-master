<?php

use common\modules\ieltsExam\models\IeltsQuestionGroup;
use common\modules\ieltsExam\models\IeltsQuestions;
use soft\grid\GridView;
use soft\widget\bs4\TabMenu;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\ieltsExam\models\search\IeltsQuestionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model IeltsQuestionGroup */

$this->title = Yii::t('app', 'Ielts Questions');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= TabMenu::widget(
    ['items' => [
        [
            'label' => t('Back'),
            'url' => ['/ielts-exam/ielts-question-group-reading/index', 'id' => $model->exam->id, 'data-pjax' => '0',],
            'icon' => 'reply,fas',
            'color' => 'default',
        ],
    ]
    ]) ?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => false,
            'url' => ['ielts-questions-reading/create', 'id' => $model->id, ['data-pjax' => 0]],
        ]
    ],
    'columns' => [
        [
            'class' => '\kartik\grid\ExpandRowColumn',
            'attribute' => 'value',
            'format' => 'raw',
            'value' => function () {
                return GridView::ROW_COLLAPSED;
            },
            'detailRowCssClass' => 'white-color',
            'expandOneOnly' => true,
            'detail' => function ($model) {
                return $this->render('_question-detail', ['model' => $model]);
            }
        ],
        [
            'attribute' => 'value',
            'label' => 'Questions',
            'format' => 'raw',
            'width' => '450px',
            'value' => function ($model) {
                return $model->value ?? 'N/A';
            }
        ],
        [
            'attribute' => 'question_group_id',
            'value' => function ($model) {
                return $model->questionGroup->sectionName();
            },
            'filter' => IeltsQuestionGroup::sectionsReadingSpeaking()
        ],
        [
            'attribute' => 'type_id',
            'value' => function ($model) {
                return $model->typeName();
            },
            'filter' => IeltsQuestions::types()
        ],
        [
            'attribute' => 'info',
            'value' => function ($model) {
                return $model->info ?? ' - ';
            }
        ],
        'actionColumn' => [
            'template' => '{update} {delete}',
            'viewOptions' => [],
            'updateOptions' => [],
        ],
    ],
]); ?>
    