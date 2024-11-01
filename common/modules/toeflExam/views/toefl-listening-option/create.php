<?php


use common\modules\toeflExam\models\EnglishExam;
use common\modules\toeflExam\models\ToeflOption;

/* @var $this soft\web\View */
/* @var $model common\modules\toeflExam\models\ToeflQuestion */
/* @var $exam EnglishExam */

/* @var $modelsOption ToeflOption */


$this->title = Yii::t('site', 'Create a new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Toefl Listening'), 'url' => ['toefl-listening-option/index', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
    'modelsOption' => $modelsOption,
]) ?>
