<?php

use soft\helpers\Html;
use soft\widget\input\PhoneMaskedInput;
use soft\widget\kartik\Form;
use soft\widget\adminlte3\Card;
use soft\widget\kartik\ActiveForm;
use soft\widget\input\VisiblePasswordInput;
use common\modules\usermanager\models\User;
use common\modules\usermanager\models\AuthItem;

/* @var $model User */
/* @var $form ActiveForm */
/* @var $this soft\web\View */


$passwordHint = '';
if (!$model->isNewRecord) {
    $passwordHint = Yii::t('app', 'Password-Hint');
}

$roles = AuthItem::userRoles();


?>
<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton(t( 'Save'), ['visible' => !$this->isAjax]) ?>
            <?= a(t('Cancel'), ['index'], ['class' => 'btn btn-warning']) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">

        <?= Form::widget([
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'full_name',
                'username:widget'=>[
                    'widgetClass' => PhoneMaskedInput::class,
                ],
                'password:widget' => [
                    'widgetClass' => VisiblePasswordInput::class,
                    'hint' => $passwordHint
                ],
                'status:radioButtonGroup' => [
                    'items' => User::statuses(),
                ],
            ]
        ]); ?>

    </div>
    <div class="col-md-6">

        <?php Card::begin() ?>

        <h3><?=t('User role');?></h3>

        <br>

        <?php foreach ($roles as $role): ?>

            <?= Html::radio('RoleName[]', $model->can($role->name), [
                'label' => $role->name,
                'value' => $role->name,
            ]) ?>

            <br>
        <?php endforeach; ?>

        <?php Card::end() ?>
    </div>

</div>


<?php ActiveForm::end(); ?>
