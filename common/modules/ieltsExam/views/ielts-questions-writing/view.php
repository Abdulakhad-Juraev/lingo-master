<?php


/* @var $this soft\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsQuestionGroup */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'IELTS Writing Questions'), 'url' => ['index', 'id' => $model->exam->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'attribute' => 'exam_id',
            'value' => function ($model) {
                return $model->exam->title ?? '-';
            },
        ],
        'info',
        [
            'attribute' => 'section',
            'value' => function ($model) {
                return $model->sectionName();
            },
        ],
        [
            'attribute' => 'value',
            'label' => 'Questions',
            'format' => 'raw',
            'width' => '50px',
            'value' => function ($model) {
                return $model->value ?? 'N/A';
            }
        ],
        [
            'attribute' => 'type_id',
            'value' => function ($model) {
                return $model->typeName();
            },
        ],
        'created_at',
        [
            'attribute' => 'createdBy',
            'value' => function ($model) {
                return $model->createdBy->firstname;
            },
        ],
        'updated_at',
        [
            'attribute' => 'updatedBy',
            'value' => function ($model) {
                return $model->updatedBy->firstname;
            },
        ]
    ],
]) ?>
