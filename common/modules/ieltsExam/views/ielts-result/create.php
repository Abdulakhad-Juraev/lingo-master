<?php


/* @var $this soft\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsResult */

$this->title = Yii::t('site', 'Create a new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ielts Results'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>