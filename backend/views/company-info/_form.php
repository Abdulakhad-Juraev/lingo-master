<?php

use kartik\widgets\SwitchInput;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\file\FileInput;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\CompanyInfo */

?>
<div class="card card-info card-outline">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'instagram')->textInput() ?>
        <?= $form->field($model, 'telegram')->textInput() ?>
        <?= $form->field($model, 'twitter')->textInput() ?>
        <?= $form->field($model, 'facebook')->textInput() ?>
        <?= $form->field($model, 'youtube')->textInput() ?>
        <?= $form->field($model, 'logo')->widget(FileInput::classname(), [
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