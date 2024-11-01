<?php

use backend\modules\regionmanager\models\District;
use backend\modules\regionmanager\models\Region;
use frontend\models\SignupForm;
use kartik\depdrop\DepDrop;
use soft\helpers\Url;
use soft\widget\kartik\Select2;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model SignupForm */

$this->title = "Ma'lumotlarni to'ldirish";
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
                            <h2>Ma'motlarni to'ldiring!</h2>
                            <p>Test ishlash uchun o'zingiz haqingizda ma'lumotlarni kiriting!</p>
                        </div>

                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <?= $form->field($model, 'firstname')->textInput(['autofocus' => true]) ?>
                        <br>
                        <?= $form->field($model, 'lastname')->textInput() ?>
                        <br>
                        <?= $form->field($model, 'region_id')->widget(Select2::classname(), [
                            'data' => Region::regions(),
                            'options' => ['placeholder' => 'Viloyatni tanlang...', 'id' => 'cat-id'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                        <br>
                        <?= $form->field($model, 'district_id')->widget(DepDrop::classname(), [
                            'type' => DepDrop::TYPE_SELECT2,
                            'data' => District::getDistricts($model->region_id),
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'options' => ['id' => 'subcat-id'],
                            'pluginOptions' => [
                                'depends' => ['cat-id'],
                                'placeholder' => 'Tumanni tanlang...',
                                'url' => Url::to(['site/district']),
                            ]
                        ]); ?>
                        <br>
                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <br>
                        <?= $form->field($model, 'password_repeat')->passwordInput() ?>

                        <div class="signup signup-submit">
                            <?= Html::submitButton("Ma'lumotlarni yuborish", ['class' => 'signup signup-submit', 'name' => 'login-button']) ?>
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