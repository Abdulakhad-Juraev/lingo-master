<?php


use common\models\User;
use common\modules\testmanager\models\Question;
use common\modules\testmanager\models\Subject;
use common\modules\usermanager\models\Balance;
use common\modules\usermanager\models\UserPayment;
use soft\widget\adminlte3\InfoBoxWidget;

$subject = Subject::find()->andWhere(['status' => Subject::STATUS_ACTIVE])->count();
$questions = Question::find()->andWhere(['status' => Question::STATUS_ACTIVE])->count();
$totalPaymentSum = UserPayment::find()->sum('amount') ?? 0;
$totalPaymentSum = Yii::$app->formatter->asInteger($totalPaymentSum);
$usersCount = User::find()
    ->where(['!=', 'id', Yii::$app->user->getId()])
    ->andWhere(['is not', 'type_id', null])
    ->count();
$formatter = Yii::$app->formatter;

?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <?= InfoBoxWidget::widget(
                    [
                        'iconBackground' => InfoBoxWidget::TYPE_INFO,
                        'number' => $totalPaymentSum . " so'm",
                        'text' => t('User payments'),
                        'icon' => 'fas fa-coins',
                    ]
                ); ?>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <?= InfoBoxWidget::widget(
                    [
                        'iconBackground' => InfoBoxWidget::TYPE_SUCCESS,
                        'number' => $formatter->asInteger($usersCount),
                        'text' => t('System Users'),
                        'icon' => 'fas fa-users',
                    ]
                ); ?>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <?= InfoBoxWidget::widget(
                    [
                        'iconBackground' => InfoBoxWidget::TYPE_DANGER,
                        'number' => $formatter->asInteger($subject),
                        'text' => t('Subjects'),
                        'icon' => 'fas fa-book',
                    ]
                ); ?>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <?= InfoBoxWidget::widget(
                    [
                        'iconBackground' => InfoBoxWidget::TYPE_SUCCESS,
                        'number' => $formatter->asInteger($questions),
                        'text' => t('Questions'),
                        'icon' => 'fas fa-users',
                    ]
                ); ?>
            </div>
        </div>
    </div>
</section>
