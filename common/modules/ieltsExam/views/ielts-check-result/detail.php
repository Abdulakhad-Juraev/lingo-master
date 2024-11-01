<?php

use common\modules\ieltsExam\models\IeltsQuestionGroup;
use common\modules\ieltsExam\models\IeltsResultItem;
use soft\widget\bs4\TabMenu;

/* @var $this soft\web\View */
/* @var $model IeltsQuestionGroup */
/* @var $searchModel \common\modules\ieltsExam\models\search\IeltsResultItemSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ielts Questions');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= TabMenu::widget(
    ['items' => [
        [
            'label' => t('Back'),
            'url' => ['/ielts-exam/ielts-check-result', 'data-pjax' => '0',],
            'icon' => 'reply,fas',
            'color' => 'default',
        ],
        [
            'label' => t('Writing'),
            'url' => ['/ielts-exam/ielts-check-result/detail', 'data-pjax' => '0', 'id' => $model->id],
            'icon' => 'book,fas',
            'color' => 'default',
        ],
        [
            'label' => t('Speaking'),
            'url' => ['/ielts-exam/ielts-check-result/speaking-detail', 'data-pjax' => '0', 'id' => $model->id],
            'icon' => 'volume-up,fas',
            'color' => 'default',
        ],
    ]
    ]) ?>
<?php
$toolbarButtons = [];
$toolbarTemplate = '{refresh}';

if (!$model->writing_score) {
    $toolbarButtons['writing'] = [
        'icon' => 'fa fa-book',
        'url' => ['ielts-check-result/grade-writing', 'id' => $model->id],
        'title' => t('Grade Writing'),
        'options' => [
            'role' => 'modal-remote',
            'class' => 'btn btn-default',
        ],
    ];
    $toolbarTemplate = '{writing}{refresh}';
}
?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => $toolbarTemplate,
    'toolbarButtons' => $toolbarButtons,
    'columns' => [
        [
            'attribute' => 'question',
            'format' => 'raw',
            'value' => function (IeltsResultItem $model) {
                return $model->question->value;
            }
        ],
        [
            'attribute' => 'value',
            'format' => 'raw',
        ],

    ],
]); ?>
