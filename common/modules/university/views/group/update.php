<?php

use yii\helpers\Html;

/* @var $this soft\web\View */
/* @var $model common\modules\university\models\Group */

$this->title = Yii::t('site', 'Update');
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
