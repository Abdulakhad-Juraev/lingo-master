<?php

use common\modules\auth\models\AuthItem;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model AuthItem */


$this->title = Yii::t('site', 'Update');
$this->params['breadcrumbs'][] = ['label' => 'Роллар', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(); ?>

<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        'name',
        'category_id:select2' => [
            'options' => [
                'data' => AuthItem::typeOneRules()
            ]
        ],
        'description',
    ]
]); ?>
<div class="form-group">
    <?= Html::nonAjaxSubmitButton() ?>
</div>

<?php ActiveForm::end(); ?>

