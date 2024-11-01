<?php

use common\modules\toeflExam\models\EnglishExam;

/* @var $this soft\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsQuestions */
/* @var $exam EnglishExam */

$this->title = Yii::t('site', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'IELTS Speaking Questions'), 'url' => ['index', 'id' => $model->exam_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

