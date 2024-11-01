<?php

use yii\helpers\Html;

/* @var $this soft\web\View */
/* @var $model common\modules\englishExam\models\ToeflQuestion */
/* @var $modelsOption common\modules\englishExam\models\ToeflQuestion */

$this->title = Yii::t('site', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Toefl Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->value, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
    'modelsOption' => $modelsOption,

]) ?>

