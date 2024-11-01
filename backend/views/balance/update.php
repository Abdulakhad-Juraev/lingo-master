<?php

use common\modules\usermanager\models\Balance;

/* @var $this yii\web\View */
/* @var $model Balance */

$this->title = Yii::t('app','Update'). $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Balance'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

echo $this->render('_form', [
'model' => $model,
]);