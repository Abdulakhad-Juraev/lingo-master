<?php

use common\modules\ieltsExam\models\IeltsQuestionGroup;
use soft\helpers\Html;
use soft\helpers\Url;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\ieltsExam\models\search\IeltsQuestionGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'IELTS Listening Group');
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
            'url' => Url::to(['ielts-question-group-listening/create', 'id' => $exam->id])
        ]
    ],
    'columns' => [
        [
            'attribute' => 'audio',
            'format' => 'raw',
            'width' => '350px',
            'value' => function (IeltsQuestionGroup $model) {
                return \yii\helpers\Html::tag('audio', '', [
                    'controls' => true,
                    'src' => $model->audioUrl,
                ]);
            }
        ],
        [
            'attribute' => 'section',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->sectionName(),
                    ['ielts-questions-listening/index', 'id' => $model->id],
                    ['data-pjax' => 0]);
            },
            'filter' => IeltsQuestionGroup::sectionsListening()
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->statusBadge;
            },
            'filter' => IeltsQuestionGroup::statuses(),
        ],
        'actionColumn' => [
            'viewOptions' => [],
            'updateOptions' => [],
        ],
    ],
]); ?>
    