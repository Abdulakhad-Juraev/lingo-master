<?php

use yii\helpers\Html;

/* @var $this soft\web\View */
/* @var $model \common\modules\usermanager\models\TeacherForm */

$this->title =  t('site', 'Update');
$this->params['breadcrumbs'][] = ['label' => t('app', 'Teachers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->firstname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

