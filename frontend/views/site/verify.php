<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model LoginForm */

use aneeshikmat\yii2\Yii2TimerCountDown\Yii2TimerCountDown;
use common\models\LoginForm;
use common\modules\auth\models\TempUser;
use frontend\models\SignupForm;
use soft\helpers\Url;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = "Kodni yuborish";
$this->params['breadcrumbs'][] = $this->title;

$onTimeEnd = <<<JS
    window.location.href = '/';
JS;

$id = Yii::$app->session->get(SignupForm::SESSION_TEMP_USER_ID_KEY);
$leftTime = TempUser::findOne($id)->expire_at;
$phone = TempUser::findOne($id)->phone;

echo Yii2TimerCountDown::widget([
    'countDownDate' => ($leftTime) * 1000,
    'countDownReturnData' => $leftTime > 3600 ? 'from-hours' : 'from-minutes',
    'templateStyle' => 0,
    'callBack' => $onTimeEnd
]);

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
                            <h2>Kodni yuborish</h2>
                            <p>+ <?= $phone ?> shu telefon raqamiga sms orqali kelgan kodni kiriting</p>
                        </div>
                        <h3><span class="float-right text-primary"> <i class="fas fa-clock"></i> <span
                                        id="time-down-counter" class="time"></span></span></h3>
                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <?= $form->field($model, "code")->widget(MaskedInput::class, [
                            'mask' => '9999',
                            'options' => [
                                'minlength' => 4,
                                'class' => 'form-control',
                                'autofocus' => true
                            ]
                        ]) ?>

                        <div class="signup signup-submit">
                            <?= Html::submitButton('Kodni yuborish', ['class' => 'signup signup-submit', 'name' => 'login-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                        <!-- login field -->
                        <div class="login signup-submit">
                            <button>Kirish</button>
                        </div>
                        <div class=" signup login-notif">
                            Allaqachon ro'yhatdan o'tganmisiz? <span class="show-hide"><a
                                        href="<?= Url::to(['site/login']) ?>">Tizimga kirish</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>