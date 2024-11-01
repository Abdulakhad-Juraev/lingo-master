<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\file\FileInput;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\Setting */

?>


<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'company_name')->textInput() ?>
<?= $form->field($model, 'img')->widget(FileInput::class, [
    'options' => ['accept' => 'image/*'],
    'pluginOptions' => [
        'showCaption' => false,
        'showRemove' => false,
        'showUpload' => false,
        'showCancel' => false,
        'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fas fa-camera"></i> ',
        'browseLabel' => 'Rasimni tanlang'
    ],
])->label(false) ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

