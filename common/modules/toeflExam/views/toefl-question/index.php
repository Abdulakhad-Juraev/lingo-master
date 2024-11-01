<?php

use common\modules\toeflExam\models\EnglishExam;
use common\modules\toeflExam\models\ToeflQuestion;
use soft\grid\GridView;
use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\toeflExam\models\search\ToeflQuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model EnglishExam */

$this->title = Yii::t('app', 'Toefl Writing Group');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();

?>
<?= $this->render('@common/views/menu/_tab-menu', ['model' => $model]) ?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => false,
            'url' => ['create', 'exam_id' => $model->id],
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
                return $this->render('_question_detail', ['model' => $model]);
            }
        ],
        [
            'attribute' => 'value',
            'label' => t('Text'),
            'format' => 'raw',
        ],
        [
            'attribute' => 'test_type_id',
            'format' => 'raw',
            'value' => function (ToeflQuestion $model) {
                return $model->writingTypeNames();
            },
            'filter' => ToeflQuestion::abcTypes()
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function (ToeflQuestion $model) {
                return $model->statusBadge;
            },
            'filter' => ToeflQuestion::statuses()
        ],
        'actionColumn' => [
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return a('<i class="fa fa-pen"></i>', to(['toefl-question/update', 'id' => $model->id]), ['data-pjax' => '0']
                    );
                },
                'view' => function ($url, $model, $key) {
                    return a('<i class="fa fa-eye"></i>', to(['toefl-question/view', 'id' => $model->id]), ['data-pjax' => '0']);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fa fa-trash"></i>', ['toefl-question/delete-writing', 'id' =>
                        $model->id], [
                        'title' => Yii::t('app', 'Delete'),
                        'aria-label' => Yii::t('app', 'Delete'),
                        'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
                },
            ]
        ],

    ],
]); ?>
    