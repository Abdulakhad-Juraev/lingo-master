<?php

use common\modules\ieltsExam\models\IeltsQuestionGroup;
use common\modules\ieltsExam\models\IeltsQuestions;
use soft\grid\GridView;
use soft\widget\bs4\TabMenu;
use yii\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\ieltsExam\models\search\IeltsQuestionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model IeltsQuestions */

$this->title = Yii::t('app', 'IELTS Speaking Questions');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= $this->render('@common/views/menu/_tab-menu-ielts', ['model' => $model]) ?>
<?= GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => false,
            'url' => ['ielts-questions-speaking/create', 'id' => $model->id, ['data-pjax' => 0]],
        ]
    ],
    'columns' => [
        [
            'attribute' => 'value',
            'format' => 'raw',
            'width' => '550px',
            'value' => function (IeltsQuestions $model) {
                return Html::tag('audio', '', [
                    'controls' => true,
                    'src' => $model->audioUrl,
                ]);
            }
        ],
        [
            'attribute' => 'section',
            'value' => function ($model) {
                return $model->sectionName();
            },
            'filter' => IeltsQuestions::speakingReadingSection()
        ],
        'actionColumn' => [
            'template' => '{update} {delete}',
            'viewOptions' => [],
            'updateOptions' => [],
        ],
    ],
]); ?>
    