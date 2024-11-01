<?php

use kartik\widgets\SwitchInput;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\Faq */

?>

<div class="card card-info card-outline">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <?php echo $form->languageSwitcher($model) ?>
        <?= $form->field($model, 'question')->textInput() ?>
        <?= $form->field($model, 'answer')->textInput() ?>
        <?= $form->field($model, 'sort_order')->textInput() ?>
        <?= $form->field($model, 'status')->widget(SwitchInput::class) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
