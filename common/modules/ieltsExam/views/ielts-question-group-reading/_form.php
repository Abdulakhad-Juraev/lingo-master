<?php

use common\modules\ieltsExam\models\IeltsQuestionGroup;
use kartik\switchinput\SwitchInput;
use mihaildev\ckeditor\CKEditor;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;

/* @var $this soft\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsQuestionGroup */

?>
<div class="card card-primary card-outline">
    <div class="card-body">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]) ?>
        <div class="col-md-12" style="margin-top: 10px">
            <?php echo $form->field($model, 'content')->widget(CKEditor::class); ?>
        </div>
        <div class="col-md-12" style="margin-top: 10px">
            <?php echo $form->field($model, 'section')->dropDownList(IeltsQuestionGroup::sectionsReadingSpeaking()); ?>
        </div>
        <div class="col-md-12" style="margin-top: 10px">
            <?php echo $form->field($model, 'status')->widget(SwitchInput::className()); ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Saqlash', ['class' => 'btn btn-primary mt-3']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>


