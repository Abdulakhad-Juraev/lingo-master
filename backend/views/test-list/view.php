<?php


/* @var $this soft\web\View */
/* @var $model common\models\TestList */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Test Lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'title',
        'description',
        'image',
        'statusBadge:raw',
        'created_at',
        'updated_at',
    ],
]) ?>
