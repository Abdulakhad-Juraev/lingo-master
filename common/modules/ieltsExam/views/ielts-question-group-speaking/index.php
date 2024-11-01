<?php

use common\modules\ieltsExam\models\IeltsQuestionGroup;
use soft\helpers\Html;
use soft\helpers\Url;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\ieltsExam\models\search\IeltsQuestionGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ielts Question Groups');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();

?>
<?= $this->render('@common/views/menu/_tab-menu-ielts', ['model' => $exam]) ?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => false,
            'url' => Url::to(['ielts-question-group-speaking/create', 'id' => $exam->id])
        ]
    ],
    'columns' => [
        [
            'attribute' => 'content',
            'format' => 'raw',
            'width' => '500px',
            'value' => function (IeltsQuestionGroup $model) {
                $content = $model->content;
                $words = explode(' ', strip_tags($content));
                $first50Words = implode(' ', array_slice($words, 0, 50));
                return Html::a($first50Words,
                    ['ielts-questions-speaking/index', 'id' => $model->id],
                    ['data-pjax' => 0]
                );
            },
        ],
        [
            'attribute' => 'section',
            'format' => 'raw',
            'value' => function (IeltsQuestionGroup $model) {
                return $model->sectionName();
            },
            'filter' => IeltsQuestionGroup::sectionsReadingSpeaking()
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'width' => '220px',
            'value' => 'statusBadge',
            'filter' => IeltsQuestionGroup::statuses()
        ],
        'actionColumn' => [
            'viewOptions' => [
                'role' => 'modal-remote => false',
            ],
            'updateOptions' => [
                'role' => 'modal-remote => false',
            ],
        ],
    ],
]); ?>
    