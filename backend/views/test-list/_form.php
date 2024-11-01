<?php

use kartik\switchinput\SwitchInput;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\file\FileInput;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\TestList */

?>

<div class="card card-info card-outline">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->languageSwitcher($model) ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'title')->textInput() ?>
        <?= $form->field($model, 'description')->textInput() ?>
        <?php
        echo $form->field($model, 'image')->widget(FileInput::classname(), [
            'options' => ['img' => 'image/*'],
        ]);
        ?>
        <?= $form->field($model, 'status')->widget(SwitchInput::class) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
