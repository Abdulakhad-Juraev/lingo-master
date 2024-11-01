<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\search\BalanceSearch;

/* @var $this yii\web\View */
/* @var $model BalanceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="balance-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
            'options' => [
        'data-pjax' => 1
        ],
        ]); ?>

        <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'value') ?>

    <?= $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'reason') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'order_history_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn
        btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
