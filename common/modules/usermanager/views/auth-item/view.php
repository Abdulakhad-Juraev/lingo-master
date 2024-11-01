<?php


/* @var $this soft\web\View */
/* @var $model backend\modules\usermanager\models\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'panel' => $this->isAjax ? false : [],
        'attributes' => [
              'name', 
              'type', 
              'description', 
              'rule_name', 
              'data', 
              'created_at', 
              'updated_at', 
        ],
    ]) ?>