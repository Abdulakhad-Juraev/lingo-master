<?php


use common\modules\toeflExam\models\EnglishExam;
use common\modules\toeflExam\models\ToeflOption;

/* @var $this soft\web\View */
/* @var $model common\modules\toeflExam\models\ToeflQuestion */
/* @var $exam EnglishExam */

/* @var $modelsOption ToeflOption */


$this->title = t('Create');
$this->params['breadcrumbs'][] = ['label' => t('Toefl Reading Options'), 'url' => ['toefl-reading-option/index', 'id'
=> $model->reading_group_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
    'modelsOption' => $modelsOption,
]) ?>
