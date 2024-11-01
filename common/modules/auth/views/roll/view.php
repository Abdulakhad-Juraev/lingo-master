<?php


/* @var $this soft\web\View */
/* @var $model common\modules\settings\models\DollarHistory */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Роллар', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\widget\adminlte2\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'name',
        'description',
        'created_at',
        'updated_at',
    ],
]) ?>
