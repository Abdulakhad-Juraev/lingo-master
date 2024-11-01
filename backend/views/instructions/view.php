<?php


/* @var $this soft\web\View */
/* @var $model common\models\Instructions */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Instructions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'attributes' => [
              'id', 
              'content', 
              'type_id', 
              'status', 
              'created_by', 
              'updated_by', 
              'created_at', 
              'updated_at', 
'created_at',
'createdBy.fullname',
'updated_at',
'updatedBy.fullname'        ],
    ]) ?>
