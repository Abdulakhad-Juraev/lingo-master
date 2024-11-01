<?php


/* @var $this soft\web\View */
/* @var $model common\modules\usermanager\models\UserTariff */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Tariffs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'attributes' => [
              'id', 
              'user_id', 
              'tariff_id', 
              'price', 
              'started_at', 
              'expired_at', 
              'order_id', 
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
