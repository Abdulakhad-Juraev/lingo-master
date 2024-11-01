<?php

/* @var $this soft\web\View */
/* @var $model common\modules\toeflExam\models\ToeflListeningGroup */

$this->title = Yii::t('site', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Toefl Listening Groups'), 'url' => ['index', 'id' =>
    $model->exam_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

