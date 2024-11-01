<?php


/* @var $this soft\web\View */
/* @var $model common\modules\usermanager\models\UserDevice */

$this->title = $model->user->full_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Device'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'user_id',
        'device_name',
        'device_id',
        'firebase_token',
        'token',
        'statusBadge:raw',
        'updated_at',
        'updated_at',
    ],
]) ?>
