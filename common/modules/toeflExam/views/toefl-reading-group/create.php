<?php


/* @var $this soft\web\View */
/* @var $model common\modules\toeflExam\models\ToeflReadingGroup */

$this->title = Yii::t('site', 'Create a new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Toefl Reading Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
