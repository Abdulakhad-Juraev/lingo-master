<?php

/* @var $this yii\web\View */
/* @var $model common\models\Setting */

$this->title = 'Yangi sozlama';
$this->params['breadcrumbs'][] = ['label' => 'Sozlamalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


echo $this->render('_form', [
    'model' => $model,
]);