<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model \common\models\LoginForm */

use soft\helpers\Url;
use soft\widget\input\PhoneMaskedInput;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Tizimga kirish';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="dashboard" style='margin-top: -95px'>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 tab-100">
                <div class="dashboard-img">
                    <div class="container">
                        <div class="wrapper">
                            <div class="dashboard-inner">
                                <div class="img-1">
                                    <img src="<?= Url::base() ?>/template/images/left imgs/1-img.png" alt="img">
                                </div>
                                <div class="animation-delay-25ms animation-delay-25ms pop img-2">
                                    <img src="<?= Url::base() ?>/template/images/left imgs/2-img.png" alt="img">
                                </div>
                                <div class="animation-delay-50ms animation-delay-25ms pop img-3">
                                    <img src="<?= Url::base() ?>/template/images/left imgs/3-img.png" alt="img">
                                </div>
                                <div class="animation-delay-75ms pop  img-4">
                                    <img src="<?= Url::base() ?>/template/images/left imgs/4-img.png" alt="img">
                                </div>
                                <div class="animation-delay-100ms pop img-5">
                                    <img src="<?= Url::base() ?>/template/images/left imgs/5-img.png" alt="img">
                                </div>
                                <div class="animation-delay-125ms pop img-6">
                                    <img src="<?= Url::base() ?>/template/images/left imgs/6-img.png" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 tab-100">
                <div class="container">
                    <!-- sign up form -->
                    <div id="show-login" class="from-top wrapper">

                        <!-- signup heading -->
                        <div class="signup signup-heading">
                            <h2>Assalomu alaykum</h2>
                            <p>Xush kelibsiz !</p>
                        </div>

                        <!-- signup email -->
                        <div class="signup email-signup">
                            <span>Testda ishtirok etish uchun tizimga kiring yoki ro'yhatdan o'ting!</span>
                        </div>
                        <!-- signup/login form inner -->

                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <?= $form->field($model, 'username')->widget(PhoneMaskedInput::class, []) ?>
                        <br>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <br>
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>


                        <div class="signup signup-submit">
                            <?= Html::submitButton('Kirish', ['class' => 'signup signup-submit', 'name' => 'login-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                        <!-- login field -->
                        <div class="login signup-submit">
                            <button>Kirish</button>
                        </div>
                        <div class=" signup login-notif">
                            Sizda akkount yo'qmi? <span class="show-hide"><a href="<?= Url::to(['site/phone']) ?>">Ro'yhatdan o'tish</a></span><br>
                            Parolni unutdingizmi? <span class="show-hide"><a href="<?= Url::to(['site/reset-password']) ?>">Parolni tiklash</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>