<?php

/* @var $this soft\web\View */


$this->title = Yii::$app->name;

$user = Yii::$app->user;
?>
<?php if ($user->can('admin')): ?>
<!--    --><?php //= $this->render('_info_box') ?>
<!--    --><?php //= $this->render('_info_box_tariff');?>
    <div class="row">
        <div class="col-md-12 p-3">
            <?= $this->render('_daily_registrants') ?>
        </div>
    </div>
<?php endif; ?>

