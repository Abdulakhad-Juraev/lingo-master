<?php


/* @var $this soft\web\View */

/* @var $model common\modules\toeflExam\models\EnglishExam */

use common\modules\toeflExam\models\EnglishExam;
use soft\helpers\Html;
use soft\widget\bs4\DetailView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'English Exams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'short_description',
        'title',
        'price',
        [
            'attribute' => 'img',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::img($model->getFileUrl());
            }
        ],
        [
            'attribute' => 'type',
            'value' => function (EnglishExam $model) {
                return $model->typeName();
            }
        ],
        'reading_duration',
        'listening_duration',
        'writing_duration',
        'speaking_duration',
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function (EnglishExam $model) {
                return $model->statusBadge;
            }
        ],
        'created_at',
       [
            'attribute' => 'created_by',
            'value' => function (EnglishExam $model) {
                return $model->createdBy->firstname;
            }

       ],
        'updated_at',
        [
            'attribute' => 'updated_by',
            'value' => function (EnglishExam $model) {
                return $model->createdBy->firstname;
            }

        ],
    ],
]) ?>
