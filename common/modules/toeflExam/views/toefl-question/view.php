<?php


/* @var $this soft\web\View */
/* @var $model common\modules\toeflExam\models\ToeflQuestion */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Toefl Questions'), 'url' => ['index', 'id' => $model->exam_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'attribute' => 'value',
            'format' => 'raw',
        ],
        [
            'attribute' => 'type_id',
            'value' => function (\common\modules\toeflExam\models\ToeflQuestion $model) {
                return $model->typeName();
            }
        ],
        [
            'attribute' => 'test_type_id',
            'value' => function (\common\modules\toeflExam\models\ToeflQuestion $model) {
                return $model->abcTypeNames();
            }
        ],
        [
            'attribute' => 'exam_id',
            'value' => function (\common\modules\toeflExam\models\ToeflQuestion $model) {
                return $model->exam->title;
            }
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function (\common\modules\toeflExam\models\ToeflQuestion $model) {
                return $model->statusBadge;
            }
        ],
        'created_at',
        'createdBy.fullname',
        'updated_at',
        'updatedBy.fullname'
    ],
]) ?>
