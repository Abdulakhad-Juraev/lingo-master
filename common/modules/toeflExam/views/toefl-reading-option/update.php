<?php

/* @var $this soft\web\View */
/* @var $model common\modules\toeflExam\models\ToeflOption */
/* @var $modelsOption common\modules\toeflExam\models\ToeflOption */
/* @var $exam \common\modules\toeflExam\models\EnglishExam */

$this->title = t('Update');
$this->params['breadcrumbs'][] =
    [
        'label' => t('Toefl Reading Options'),
        'url' => ['toefl-reading-option/index', 'id' => $model->reading_group_id]
    ];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
    'modelsOption' => $modelsOption,
]) ?>

