<?php


/* @var $this soft\web\View */
/* @var $model common\modules\toeflExam\models\ToeflListeningGroup */

$this->title = Yii::t('site', 'Create a new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Toefl Listening Groups'), 'url' => ['toefl-listening-group/index','id'=>$group->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,

]) ?>
