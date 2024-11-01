<?php


/* @var $this soft\web\View */
/* @var $model backend\modules\usermanager\models\AuthItem */

$this->title = Yii::t('site', 'Create a new');
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>