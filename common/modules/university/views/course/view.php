<?php


/* @var $this soft\web\View */
/* @var $model common\modules\university\models\Course */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Course'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'statusBadge:raw',
        'created_at',
        'createdBy.fullname',
        'updated_at',
        'updatedBy.fullname'
    ],
]) ?>
