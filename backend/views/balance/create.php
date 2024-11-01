<?php

use common\modules\usermanager\models\Balance;

/**
 * @var $this yii\web\View
 * @var $model Balance
 * @var $drivers array
 */

$this->title = Yii::t('app', 'Complete the account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Balance'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_form', [
    'model' => $model,
    'users' => $users
]);