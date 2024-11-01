<?php

use common\modules\auth\models\AuthItem;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model AuthItem */

?>


<?php $form = ActiveForm::begin(); ?>

<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        'name',
        'description:textarea',
    ]
]); ?>
<div class="form-group">
    <?= Html::nonAjaxSubmitButton() ?>
</div>

<?php ActiveForm::end(); ?>

