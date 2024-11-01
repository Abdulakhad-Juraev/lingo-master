<?php

use kartik\switchinput\SwitchInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Settings */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="card">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput([
            'disabled' => true
        ]) ?>

        <?= $form->field($model, 'info')->textInput([
            'disabled' => true
        ]) ?>

        <?php switch ($model->type):
            case \common\models\Settings::TYPE_BOOLEAN:
                echo $form->field($model, 'value')->widget(SwitchInput::class, [
                    'pluginOptions' => [
                        'onText' => 'ON',
                        'offText' => 'OFF',
                    ]
                ]);
                break;
            default:
                echo $form->field($model, 'value')->textInput();
        endswitch;
        ?>

        <div class="row">
            <div class="col d-flex justify-content-end">
                <?= Html::submitButton('Saqlash', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
