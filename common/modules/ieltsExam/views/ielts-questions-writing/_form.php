<?php

use common\modules\ieltsExam\models\IeltsQuestions;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Select2;

/* @var $this soft\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsQuestions */

?>


<div class="card card-outline-primary">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'info')->textInput() ?>
        <?= $form->field($model, 'section')->widget(Select2::class, [
            'data' => IeltsQuestions::sections(),
        ]) ?>
        <?= $form->field($model, 'value')->widget(CKEditor::className(), [
            'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                'preset' => 'advanced',
                'inline' => false,
            ]),
        ]); ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

