<?php

use common\modules\toeflExam\models\ToeflResult;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\toeflExam\models\search\ToeflResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Toefl Results');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => true,
        ]
    ],
    'columns' => [
        [
            'attribute' => 'user_id',
            'label' => t('User'),
            'value' => function (ToeflResult $model) {
                return $model->user->full_name;
            },
        ],
        [
            'attribute' => 'exam_id',
            'value' => function (ToeflResult $model) {
                return $model->exam->title;
            },
        ],
        'listening_score',
        'reading_score',
        'writing_score',
        'cefr_level',
        'started_at:datetime',
//       'started_at_listening',
        //'started_at_reading',
        //'started_at_writing',
        //'expire_at',
        //'expire_at_listening',
        //'expire_at_reading',
        //'expire_at_writing',
        //'reading_duration',
        //'writing_duration',
        //'listening_duration',
        //'correct_answers_listening',
        //'correct_answers_reading',
        //'correct_answers_writing',
//        'price',
        'finished_at:datetime',
        //'finished_at_listening',
        //'finished_at_reading',
        //'finished_at_writing',
        //'step',
        //'status',
        //'created_by',
        //'updated_by',
        //'created_at',
        //'updated_at',

        'actionColumn' => [
            'template' => '{view}',
            'viewOptions' => [
                'role' => 'modal-remote',
            ],
            'updateOptions' => [
                'role' => 'modal-remote',
            ],
        ],
    ],
]); ?>
    