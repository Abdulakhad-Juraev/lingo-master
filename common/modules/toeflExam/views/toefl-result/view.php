<?php


/* @var $this soft\web\View */

/* @var $model common\modules\toeflExam\models\ToeflResult */

use common\modules\toeflExam\models\ToeflResult;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Toefl Results'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
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
        'correct_answers_listening',
        'correct_answers_reading',
        'correct_answers_writing',
        'listening_score',
        'reading_score',
        'writing_score',
        'cefr_level',
        'price',
        'started_at:datetime',
        'started_at_listening:datetime',
        'started_at_reading:datetime',
        'started_at_writing:datetime',
        'expire_at:datetime',
        'expire_at_listening:datetime',
        'expire_at_reading:datetime',
        'expire_at_writing:datetime',
        'reading_duration:datetime',
        'writing_duration:datetime',
        'listening_duration:datetime',
        'finished_at:datetime',
        'finished_at_listening:datetime',
        'finished_at_reading:datetime',
        'finished_at_writing:datetime',
        'step',
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->statusBadge;
            }
        ],
        'created_at',
        [
            'attribute' => 'created_by',
            'value' => function ($model) {
                return $model->createdBy->full_name;
            }
        ],
        'updated_at',
    ],
]) ?>
