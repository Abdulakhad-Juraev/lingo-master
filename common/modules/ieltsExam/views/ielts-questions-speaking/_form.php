<?php

use common\modules\ieltsExam\models\IeltsQuestions;
use common\modules\testmanager\widgets\CKEditorForDynamicForm;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\file\FileInput;
use soft\widget\kartik\Select2;
use mihaildev\elfinder\ElFinder;


/* @var $this soft\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsQuestions */


\yii\jui\JuiAsset::register($this);

$host = Yii::$app->request->hostInfo;
$wirisJsUrl = $host . '/ckeditor/plugins/ckeditor_wiris/plugin.js';
$this->registerJs("CKEDITOR.plugins.addExternal('ckeditor_wiris', '" . $wirisJsUrl . "', '');");

$ckeditorOptions = ElFinder::ckeditorOptions('elfinder', [
    'height' => '80px',
    'allowedContent' => true,
    'extraPlugins' => 'ckeditor_wiris',
    'toolbarGroups' => [
        ['name' => 'undo'],
        ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
        ['name' => 'colors'],
        ['name' => 'links', 'groups' => ['insert']],
        ['name' => 'others', 'groups' => ['others']],
        ['name' => 'ckeditor_wiris']
    ]
]);


?>
<div class="card card-primary card-outline">
    <div class="card-body">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]) ?>
        <?php
        $initialPreview = [];
        $initialPreviewConfig = [];

        if ($model->value) {
            $initialPreview = [
                "<audio controls><source src='{$model->audioUrl}' type='audio/mpeg'>Your browser does not support the audio element.</audio>"
            ];
            $initialPreviewConfig = [
                ['type' => "audio", 'filetype' => "audio/mpeg"]
            ];
        }
        ?>
        <div class="col-md-12">
            <?= $form->field($model, 'section')->widget(Select2::class, [
                'data' => IeltsQuestions::speakingReadingSection()
            ]) ?>
        </div>
        <div class="custom-file">
            <?php
            echo $form->field($model, 'audioFile')->widget(FileInput::classname(), [
                'options' => ['multiple' => false, 'accept' => 'audio/*'],
                'pluginOptions' => [
                    'previewFileType' => 'audio',
                    'initialPreview' => $initialPreview,
                    'initialPreviewAsData' => false,
                    'initialPreviewConfig' => $initialPreviewConfig,
                    'showUpload' => false,
                    'showRemove' => false]
            ]);
            ?>
        </div>
        <div class="mt-4">
            <?= $form->field($model, 'info')->widget(CKEditorForDynamicForm::className(), ['editorOptions' =>
                $ckeditorOptions, 'options' => ['autofocus' => true, 'tabindex' => 1]])->label('Info') ?>

        </div>
        <div class="form-group">
            <?= Html::submitButton('Saqlash', ['class' => 'btn btn-primary mt-3']) ?>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>


