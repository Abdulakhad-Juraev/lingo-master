<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model LoginForm */

use backend\models\LoginForm;
use soft\widget\input\PhoneMaskedInput;
use soft\widget\input\VisiblePasswordInput;
use soft\widget\kartik\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::$app->name;
?>

<div class="site-login pull-left" style="background: #eee; padding: 20px; opacity: 90%; margin-top: 250px">


    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <?= $form->field($model, 'username')->widget(PhoneMaskedInput::class)->label(Yii::t('app','Login')) ?>

    <?= $form->field($model, 'password')->widget(VisiblePasswordInput::class) ?>
    
    <div class="form-group">
        <?= Html::submitButton('Kirish', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>



