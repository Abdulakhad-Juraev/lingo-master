<?php

use common\models\User;

/* @var $this soft\web\View */
/* @var $model User */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'panel' => $this->isAjax ? false : [],
    'attributes' => [
        'id',
        'username',
        'status:status',
        'created_at',
        'updated_at',
    ],
]) ?>