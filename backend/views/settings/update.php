<?php

/* @var $this yii\web\View */
/* @var $model common\models\Settings */

$this->title = 'Tahrirlash: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sozlamalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Tahrirlash';

echo $this->render('_form', [
    'model' => $model,
]);