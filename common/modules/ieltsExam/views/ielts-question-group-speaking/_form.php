<?php

use common\modules\ieltsExam\models\IeltsQuestionGroup;
use kartik\switchinput\SwitchInput;
use mihaildev\ckeditor\CKEditor;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\file\FileInput;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsQuestionGroup */

?>


<div class="card card-primary card-outline">
    <div class="card-body">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]) ?>

<!--        --><?php //// Assuming $model->audioFile contains the URL or path to the audio file
//        $initialPreview = [];
//        $initialPreviewConfig = [];
//
//        if ($model->audio) {
//            $initialPreview = [
//                "<audio controls><source src='{$model->audioUrl}' type='audio/mpeg'>Your browser does not support the audio element.</audio>"
//            ];
//            $initialPreviewConfig = [
//                ['type' => "audio", 'filetype' => "audio/mpeg"]
//            ];
//        }
//        ?>
<!---->
<!--        <div class="custom-file">-->
<!--            --><?php
//            echo $form->field($model, 'audioFile')->widget(FileInput::classname(), [
//                'options' => ['multiple' => false, 'accept' => 'audio/*'],
//                'pluginOptions' => [
//                    'previewFileType' => 'audio',
//                    'initialPreview' => $initialPreview,
//                    'initialPreviewAsData' => false,
//                    'initialPreviewConfig' => $initialPreviewConfig,
//                    'showUpload' => false, // Hide the upload button
//                    'showRemove' => false  // Hide the remove button
//                ]
//            ]);
//            ?>
<!--        </div>-->
        <div class="col-md-12" style="margin-top: 10px">
            <?php echo $form->field($model, 'content')->widget(CKEditor::class); ?>
        </div>
        <div class="col-md-12" style="margin-top: 10px">
            <?php echo $form->field($model, 'section')->dropDownList(IeltsQuestionGroup::sectionsReadingSpeaking()); ?>
        </div>
        <div class="col-md-12" style="margin-top: 10px">
            <?php echo $form->field($model, 'status')->widget(SwitchInput::class); ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Saqlash', ['class' => 'btn btn-primary mt-3']) ?>
        </div>

        <?php ActiveForm::end() ?>
    </div>

</div>


