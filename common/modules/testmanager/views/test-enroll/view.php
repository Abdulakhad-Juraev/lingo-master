<?php


/* @var $this soft\web\View */
/* @var $model common\modules\testmanager\models\TestEnroll */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Test Sale'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'attributes' => [
              'id', 
              'test_id', 
              'user_id', 
              'payment_type_id', 
              'price', 
              'count', 
'created_at',
'createdBy.fullname',
'updated_at',
'updatedBy.fullname'        ],
    ]) ?>
