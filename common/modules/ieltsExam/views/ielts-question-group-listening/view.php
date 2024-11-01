<?php


/* @var $this soft\web\View */

/* @var $model common\modules\ieltsExam\models\IeltsQuestionGroup */

use common\modules\ieltsExam\models\IeltsQuestionGroup;
use yii\helpers\Html;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'IELTS Listening Group'), 'url' => ['index', 'id' => $model->exam->id]];
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
            }
        ],
        'content',
        [
            'attribute' => 'audio',
            'format' => 'raw',
            'value' => function (IeltsQuestionGroup $model) {
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
        ],
        [
            'attribute' => 'type_id',
            'value' => function ($model) {
                return $model->typeName();
            },
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->statusBadge;
            }
        ],
        'created_at',
        [
            'attribute' => 'createdBy',
            'value' => function ($model) {
                return $model->createdBy->firstname ?? '-';
            }
        ],
        'updated_at',
        [
            'attribute' => 'updatedBy',
            'value' => function ($model) {
                return $model->updatedBy->firstname ?? '-';
            },
        ],
    ],
]) ?>
