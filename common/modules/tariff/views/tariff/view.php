<?php


/* @var $this soft\web\View */
/* @var $model common\modules\tariff\models\Tariff */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tariffs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'short_description',
        'price:sum',
        'duration_number',
        [
            'attribute' => 'duration_text',
            'format' => 'raw',
            'value' => function (\common\modules\tariff\models\Tariff $model) {
                return $model->duration_text;
            }
        ],
        'created_at',
        'createdBy.firstname',
        'updated_at',
        'updatedBy.firstname'],
]) ?>
