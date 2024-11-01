<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\acf\models\Field */

$this->title = Yii::t('app', 'Create Field');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Fields'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="field-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
