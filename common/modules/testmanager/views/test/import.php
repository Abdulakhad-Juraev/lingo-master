<?php


/* @var $this View */

/** @var ImportExcel $model */

use common\models\ImportExcel;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\web\View;

$this->title = Yii::t('app', 'Upload File');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="card card-primary card-outline">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'file')->fileInput(); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'),['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end() ?>
    </div>
</div>