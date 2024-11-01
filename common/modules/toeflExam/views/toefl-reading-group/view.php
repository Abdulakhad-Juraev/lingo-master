<?php


/* @var $this soft\web\View */
/* @var $model common\modules\toeflExam\models\ToeflReadingGroup */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Toefl Reading Groups'), 'url' => ['index','id'=>$model->exam_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'attribute' => 'text',
            'format' => 'raw',
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => $model->getStatusBadge(),
        ],
        'created_at',
        'updated_at',
    ],
]) ?>
