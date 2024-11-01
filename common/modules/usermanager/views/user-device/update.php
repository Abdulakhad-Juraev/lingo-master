<?php

use yii\helpers\Html;

/* @var $this soft\web\View */
/* @var $model common\modules\usermanager\models\UserDevice */

$this->title = Yii::t('site', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Device'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->full_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

