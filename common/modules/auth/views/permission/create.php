<?php

use common\modules\auth\models\AuthItem;
use soft\widget\dynamicform\DynamicFormAsset;

/* @var $this soft\web\View */
/* @var $model AuthItem */
/* @var $dform DynamicFormAsset */

$this->title = Yii::t('site', 'Create a new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permission'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
    'dform' => $dform,
]) ?>
