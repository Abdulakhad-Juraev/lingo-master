<?php

use common\modules\testmanager\models\Test;
use common\modules\testmanager\models\TestEnroll;
use common\modules\usermanager\models\Student;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\modules\testmanager\models\TestEnroll */

?>


<?php $form = ActiveForm::begin(); ?>

<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        'test_id:select2' => [
            'options' => [
                'data' => Test::paymetMap()
            ]
        ],
        'user_id:select2' => [
            'options' => [
                'data' => Student::map()
            ]
        ],
        'payment_type_id:select2' => [
            'options' => [
                'data' => TestEnroll::adminPaymentTypes()
            ]
        ]
    ]
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

