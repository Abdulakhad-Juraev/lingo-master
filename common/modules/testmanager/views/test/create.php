<?php

use common\modules\testmanager\models\Test;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model Test */

$this->title = Yii::t('site', 'Create a new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Test'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
