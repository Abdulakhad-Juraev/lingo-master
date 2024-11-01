<?php


/* @var $this soft\web\View */
/* @var $model common\modules\usermanager\models\UserPayment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'attributes' => [
              'id', 
              'user_id', 
              'amount', 
              'comment', 
              'type_id', 
              'transaction_id', 
              'created_by', 
              'updated_by', 
              'created_at', 
              'updated_at', 
'created_at',
'createdBy.fullname',
'updated_at',
'updatedBy.fullname'        ],
    ]) ?>
