<?php

use common\modules\toeflExam\models\EnglishExam;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\file\SingleImageFileInput;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\modules\toeflExam\models\EnglishExam */

?>


<?php $form = ActiveForm::begin(); ?>
<?= $form->languageSwitcher($model) ?>
<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        'title',
        'short_description:textarea',
        'price',
        'type:select2' => [
            'options' => [
                'data' => EnglishExam::types()
            ]
        ],
        'reading_duration',
        'listening_duration',
        'writing_duration',
        'speaking_duration',
        'img:widget' => [
            'widgetClass' => SingleImageFileInput::class,
            'options' => [
                'initialPreviewUrl' => $model->getFileUrl(),
            ]
        ],
        'status:status',
    ]
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

