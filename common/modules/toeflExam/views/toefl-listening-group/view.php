<?php


/* @var $this soft\web\View */

/* @var $model common\modules\toeflExam\models\ToeflListeningGroup */

use common\modules\toeflExam\models\ToeflListeningGroup;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Toefl Listening Groups'), 'url' => ['index', 'id' =>
    $model->exam_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'attribute' => 'audio',
            'format' => 'raw',
            'value' => function (ToeflListeningGroup $conversationToefl) {
                return \yii\helpers\Html::tag('audio', '', [
                    'controls' => true,
                    'src' => $conversationToefl->audioUrl,
                ]);
            }
        ],
        'exam_id',
        'type_id',
        'status',
        'created_at',
        'createdBy.fullname',
        'updated_at',
        'updatedBy.fullname'],
]) ?>
