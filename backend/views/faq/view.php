<?php


/* @var $this soft\web\View */
/* @var $model common\models\Faq */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faqs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'question',
        'answer',
        'sort_order',
        'statusBadge:raw',
        'created_at',
        'createdBy.fullname',
        'updated_at',
        'updatedBy.fullname'],
]) ?>
