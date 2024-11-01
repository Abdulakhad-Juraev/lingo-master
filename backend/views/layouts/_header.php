<?php

/* @var $this \yii\web\View */

use common\modules\ieltsExam\models\IeltsResult;
use soft\helpers\Html;
use soft\helpers\PhoneHelper;
use yii\helpers\Url;


$formatter = Yii::$app->formatter;
$params = Yii::$app->params;
$languages = $params['languages'];
$languageParam = $params['languageParam'];
$activeLanguage = Yii::$app->request->get($languageParam, $params['defaultLanguage']);
if (!array_key_exists($activeLanguage, $params['languages'])) {
    $activeLanguage = $params['defaultLanguage'];
}
$unCheckedResult='';
/*
$unCheckedResult = IeltsResult::find()
    ->andWhere(['ielts_result.status' => IeltsResult::STATUS_INACTIVE])
    ->andWhere([
        'or',
        ['is', 'ielts_result.speaking_score', null],
        ['is', 'ielts_result.writing_score', null],
    ])->count();*/
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item">
            <a href="<?= to(['/site/index']) ?>" class="nav-link"><i
                        class="fas fa-home"></i> <?= Yii::t('app', 'Home') ?></a>
        </li>


        <?php foreach ($languages as $key => $label): ?>

            <?php if ($activeLanguage == $key): ?>

                <li class="nav-item active">
                    <a class="nav-link"> <i class="fas fa-check"></i> <?= $label ?></a>
                </li>

            <?php else: ?>
                <li class="nav-item active">
                    <a href="<?= Url::current(['lang' => $key]) ?>" class="nav-link text-info"><?= $label ?></a>
                </li>
            <?php endif ?>

        <?php endforeach; ?>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <?php if ($unCheckedResult > 0): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= Url::to(['/ielts-exam/ielts-check-result']) ?>">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge"><?= $unCheckedResult ?></span>
                </a>
            </li>
        <?php endif; ?>
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <i class="fas fa-user mr-2"></i>
                <span class="hidden-xs "> <?= '+998 ' . PhoneHelper::formatPhoneNumber(user()->username); ?></span>
                <i class="fas fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li class="user-header">
                    <img src="<?= Yii::$app->user->identity->photoUrl ?? '/template/images/avatar-1.png' ?>"
                         class="img-circle"
                         alt="User Image"/>
                    <p>
                        <?= '+998 ' . PhoneHelper::formatPhoneNumber(user()->username); ?>
                    </p>
                </li>
                <!-- Menu Body -->
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="float-left">
                        <a href="<?= Url::to(['/profile-manager']) ?>" class="btn btn-default btn-flat">
                            <span class="fas fa-user-cog"></span> <?= Yii::t('app', 'Personal cabinet') ?>
                        </a>
                        <?= Html::a(
                            fas('sign-out-alt') . Yii::t('app', 'Logout'),
                            ['/site/logout'],
                            ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                        ) ?>
                    </div>

                </li>
            </ul>
        </li>

    </ul>
</nav>
<!-- /.navbar -->
