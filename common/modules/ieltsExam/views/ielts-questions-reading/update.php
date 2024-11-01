<?php

use yii\helpers\Html;

/* @var $this soft\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsQuestions */
/* @var $exam \common\modules\toeflExam\models\EnglishExam */
/* @var $modelsOption \common\modules\ieltsExam\models\IeltsOptions[] */

$this->title = Yii::t('site', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ielts Questions'), 'url' => ['index', 'id' => $model->question_group_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
    'modelsOption' => $modelsOption,
]) ?>

