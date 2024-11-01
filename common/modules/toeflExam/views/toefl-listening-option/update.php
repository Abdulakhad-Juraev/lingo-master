<?php

/* @var $this soft\web\View */
/* @var $model common\modules\toeflExam\models\ToeflOption */
/* @var $modelsOption common\modules\toeflExam\models\ToeflOption */

$this->title = t('Update');
$this->params['breadcrumbs'][] = ['label' => t('Toefl Listening Options'), 'url' => ['toefl-listening-option/index', 'id' => $model->listening_group_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
    'modelsOption' => $modelsOption,
]) ?>

