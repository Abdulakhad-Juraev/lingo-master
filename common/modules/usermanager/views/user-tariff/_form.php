<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\modules\usermanager\models\UserTariff */

?>


<?php $form = ActiveForm::begin(); ?>

<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        'user_id:select2' => [
            'options' => [
                'data' => \common\models\User::map()
            ]
        ],
        'tariff_id:select2' => [
            'options' => [
                'data' => \common\modules\tariff\models\Tariff::map()
            ]
        ],
    ]
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

