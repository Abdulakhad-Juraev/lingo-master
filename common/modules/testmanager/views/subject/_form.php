<?php

use kartik\widgets\SwitchInput;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\file\FileInput;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\modules\testmanager\models\Subject */

?>
<div class="card card-info card-outline">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->languageSwitcher($model) ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'status')->widget(SwitchInput::class) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>


