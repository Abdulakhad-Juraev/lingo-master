<?php

use yii\helpers\Html;

/* @var $this soft\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsQuestions */
/* @var $exam \common\modules\toeflExam\models\EnglishExam */

$this->title = Yii::t('site', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'IELTS Writing Questions'), 'url' => ['index', 'id' => $model->exam->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

