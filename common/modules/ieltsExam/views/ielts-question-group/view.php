<?php


/* @var $this soft\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsQuestionGroup */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ielts Question Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'attributes' => [
              'id', 
              'exam_id', 
              'content', 
              'audio', 
              'section', 
              'type_id', 
              'status', 
              'created_by', 
              'updated_by', 
              'created_at', 
              'updated_at', 
'created_at',
'createdBy.fullname',
'updated_at',
'updatedBy.fullname'        ],
    ]) ?>
