<?php

use yii\helpers\Html;

/* @var $this soft\web\View */
/* @var $model */

$this->title = Yii::t('site', 'Update');
$this->params['breadcrumbs'][] = ['label' => 'Роллар', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

