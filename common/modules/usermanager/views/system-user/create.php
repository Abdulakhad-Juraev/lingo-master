<?php

use common\models\User;

/* @var $this soft\web\View */
/* @var $model User */


$this->title = Yii::t('site', 'Create a new');
$this->params['breadcrumbs'][] = ['label' => t('User'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>