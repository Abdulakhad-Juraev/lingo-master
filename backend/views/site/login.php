<?php

use backend\models\LoginForm;
use soft\helpers\Html;
use soft\helpers\Url;

use soft\widget\input\PhoneMaskedInput;

use soft\widget\input\VisiblePasswordInput;
use yii\bootstrap\ActiveForm;

/* @var $model LoginForm */
$this->title = Yii::$app->name;
?>
<div class="limiter">
    <div class="container-login100" style="background-image: url(<?= Url::to(['login/images/bg-01.jpg']) ?>);">
        <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
            <?php $form = ActiveForm::begin(['options'=>['class'=>'login100-form validate-form']]); ?>
					<span class="login100-form-title p-b-49">
						Login
					</span>

                <div class="wrap-input100 validate-input m-b-23">
                    <span class="label-input100"><?= Yii::t('app', 'Login');?></span>
                    <?= $form->field($model, 'username'
                        , [
                        'inputOptions' => [
                            'class' => 'input100',
                            'placeholder' => Yii::t('app', 'Login'),
                        ],
                        'options' => ['tag' => false],
                        'errorOptions' => ['tag' => false],
                    ]
                    )->widget(PhoneMaskedInput::class)->label(false);
                    ?>
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>
            <style>
                .col-error-message{
                    color: red;
                    position: absolute;
                    bottom: -32px;
                    font-size: 14px;
                    /*border: 1px solid red;*/
                }

            </style>
                <div class="wrap-input100 validate-input">
                    <span class="label-input100">Parol</span>
                    <?= $form->field($model, 'password', [
                        'inputOptions' => [
                            'class' => 'input100',
                            'placeholder' => Yii::t('app', 'Password'),
                        ],
                        'options' => ['tag' => false],
                        'errorOptions' => ['tag' => false],
                        'template' => "<div class=\"\">{input} {label}</div><span class=\"focus-input100\" data-symbol=\"&#xf190;\"></span>\n<div class=\" col-error-message\">{error}</div>",
                    ])->passwordInput([
                    ])->label(false);

                    ?>
                    <span class="focus-input100" data-symbol="&#xf190;"></span>
                </div>

                <div class="text-right p-t-8 p-b-31">
                    <a href="#">
                        Parolni tiklash ?
                    </a>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
<!--                        <button class="login100-form-btn">-->
<!--                            Login-->
<!--                        </button>-->
                        <?= Html::submitButton('Kirish', ['class' => 'login100-form-btn', 'name' => 'login-button']) ?>
                    </div>
                </div>

                <div class="txt1 text-center p-t-54 p-b-20">
						<span>
							Or Sign Up Using
						</span>
                </div>

                <div class="flex-c-m">
                    <a href="#" class="login100-social-item bg1">
                        <i class="fa fa-facebook"></i>
                    </a>

                    <a href="#" class="login100-social-item bg2">
                        <i class="fa fa-twitter"></i>
                    </a>

                    <a href="#" class="login100-social-item bg3">
                        <i class="fa fa-google"></i>
                    </a>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


<div id="dropDownSelect1"></div>