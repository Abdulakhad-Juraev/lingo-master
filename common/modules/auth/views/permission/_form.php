<?php

use common\modules\auth\models\AuthItem;
use common\modules\product\models\Product;
use soft\helpers\Html;
use soft\widget\adminlte2\BoxWidget;
use soft\widget\kartik\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model AuthItem */
/* @var $dform DynamicFormWidget */

?>
<?php $form = ActiveForm::begin([
    'id' => 'dynamic-form'
]); ?>
<div class="card border-default">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                    'data' => AuthItem::typeOneRules(),
                    'language' => 'uz',
                    'options' => ['placeholder' => '...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
        </div>
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            'min' => 1, // 0 or 1 (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $dform[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'name',
                'description'
            ],
        ]); ?>
        <div class="container-items">
            <div class="item card card-default"><!-- widgetBody -->
                <?php foreach ($dform as $i => $item): ?>
                    <?php
                    // necessary for update action.
                    if (!$item->isNewRecord) {
                        echo Html::activeHiddenInput($item, "[{$i}]name");
                    }
                    ?>

                    <div class="row ml-2">
                        <div class="col-sm-4">
                            <?= $form->field($item, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($item, "[{$i}]description")->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="remove-item btn btn-danger btn-sm" style="margin-top: 30px"><i
                                        class="fas fa-times"></i></button>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
        <div class="form-group pull-right">
            <?= Html::submitButton($model->isNewRecord ? 'Сақлаш' : 'Update', ['class' => 'btn btn-success']) ?>
            <button type="button" class="add-item btn btn-info btn-sm"><i
                        class="fas fa-plus"></i> Қўшиш</button>
        </div>
        <?php DynamicFormWidget::end(); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

