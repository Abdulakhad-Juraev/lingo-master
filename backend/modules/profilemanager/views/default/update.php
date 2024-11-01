<?php

use kartik\form\ActiveForm;
use soft\widget\adminlte3\Card;
use soft\widget\kartik\file\FileInput;
use yii\helpers\Html;


/* @var $this \yii\web\View */
/* @var $model \backend\modules\profilemanager\models\ChangePasswordForm */

$this->title = "Shaxsiy ma'lumotlarni o'zgartirish";
$this->params['breadcrumbs'][] = ['url' => ['index'], 'label' => 'Shaxsiy kabinet'];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php Card::begin() ?>
<?php $form = ActiveForm::begin() ?>
<div class="row">


    <div class="col-md-6">
        <h3 align="center"><?= $this->title ?></h3>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'firstname') ?>
        <?= $form->field($model, 'lastname') ?>
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Bekor qilish', ['index'], ['class' => 'btn btn-warning']) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'photo')->widget(FileInput::class, [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'showCancel' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="fas fa-camera"></i> ',
                'browseLabel' => 'Avatarni tanlang'
            ],
        ])->label(false) ?>

    </div>


</div>

<?php ActiveForm::end() ?>

<?php Card::end() ?>