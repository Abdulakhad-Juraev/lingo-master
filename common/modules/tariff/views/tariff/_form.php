<?php

use common\modules\tariff\models\Tariff;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\modules\tariff\models\Tariff */

?>


<?php $form = ActiveForm::begin(); ?>
<?= $form->languageSwitcher($model) ?>
<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        'name',
        'short_description',
        'price',
        'duration_number',
        'duration_text:select2' => [
            'options' => [
                'data' => Tariff::durationTexts()
            ]
        ],
        'status:status'
    ]
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

