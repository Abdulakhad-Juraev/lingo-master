<?php

use common\models\Instructions;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\Instructions */

?>


<?php $form = ActiveForm::begin(); ?>

<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        'content:ckeditor',
        'type_id:select2' => [
            'options' => [
                'data' => Instructions::typesList()
            ]
        ],
        'exam_type_id:select2' => [
            'options' => [
                'data' => Instructions::examTypesList()
            ]
        ],
        'status:status',
    ]
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

