<?php

use common\modules\toeflExam\models\EnglishExam;

/* @var $this soft\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsQuestionGroup */
/* @var $exam EnglishExam */


$this->title = Yii::t('site', 'Create a new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'IELTS Listening Group'), 'url' => ['index', 'id' => $exam->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
