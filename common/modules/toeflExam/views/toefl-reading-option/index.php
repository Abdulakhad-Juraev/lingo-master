<?php

use common\modules\toeflExam\models\EnglishExam;
use common\modules\toeflExam\models\ToeflQuestion;
use soft\grid\GridView;
use soft\widget\bs3\TabMenu;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\toeflExam\models\search\ToeflListeningGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model EnglishExam */

$this->title = t('Toefl Reading Options');
$this->params['breadcrumbs'][] = ['label' => t('Toefl Reading Groups'), 'url' => ['toefl-reading-group/index', 'id' => $model->exam->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= TabMenu::widget(
    ['items' => [
        [
            'label' => t('Back'),
            'url' => ['toefl-reading-group/index', 'id' => $model->exam->id, 'data-pjax' => '0',],
            'icon' => 'arrow-left,fas',
            'color' => 'default',
            'active' => in_array(
                Yii::$app->controller->route, [
                    'toefl-exam/toefl-reading-option/index'
                ]
            ),
        ],
    ]
    ]) ?>
<?= GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => false,
            'url' => ['toefl-reading-option/create', 'id' => $model->id, 'data-pjax' => 0,],
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
                return $this->render('_option-detail', ['model' => $model]);
            }
        ],
        [
            'attribute' => 'value',
            'label' => 'Questions',
            'format' => 'raw',
            'width' => '250px',
            'value' => function ($model) {
                return $model->value ?? 'N/A';
            }
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'width' => '100px',
            'value' => 'statusBadge',
            'filter' => ToeflQuestion::statuses()
        ],
        'actionColumn' => [
            'template' => '{update} {delete}',
            'viewOptions' => [],
            'updateOptions' => [],
        ],

    ],
]); ?>
