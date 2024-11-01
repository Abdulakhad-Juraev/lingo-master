<?php


/* @var $this soft\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsQuestions */
/* @var $modelsOption \common\modules\ieltsExam\models\IeltsOptions[] */

$this->title = Yii::t('site', 'Create a new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ielts Questions'), 'url' => ['index', 'id' => $model->question_group_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
    'modelsOption' => $modelsOption,
]) ?>
