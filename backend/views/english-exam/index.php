<?php

use common\modules\toeflExam\models\EnglishExam;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\toeflExam\models\search\EnglishExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'English Exams');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => false,
        ]
    ],
    'columns' => [
        [
            'attribute' => 'title',
            'format' => 'raw',
            'value' => static function (EnglishExam $model) {
                if ($model->type === EnglishExam::TYPE_TOEFL) {
                    return a($model->title, ['/toefl-exam/toefl-listening-group/', 'id' => $model->id], ['data-pjax' => '0']);
                } elseif ($model->type === EnglishExam::TYPE_IELTS) {
                    return a($model->title, ['/ielts-exam/ielts-question-group-listening/index', 'id' => $model->id], ['data-pjax' => '0']);
                }
                return $model->title;
            },
        ],
        'price',
        [
            'attribute' => 'type',
            'value' => function (EnglishExam $model) {
                return $model->typeName();
            },
            'filter' => EnglishExam::types()
        ],
        'reading_duration',
        'listening_duration',
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function (EnglishExam $model) {
                return $model->statusBadge;
            },
            'filter' => EnglishExam::statuses()
        ],
        //'type',
        //'status',
        //'created_by',
        //'updated_by',
        //'created_at',
        //'updated_at',
        'actionColumn' => [

        ],
    ],
]); ?>
    