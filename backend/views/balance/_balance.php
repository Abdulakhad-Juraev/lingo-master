<?php

/* @var $this View */
/* @var $model User */

use common\models\User;
use yii\web\View;

?>

<h2 class="text-center" style="font-size: 26px">«<?= $model->getFullname() ?>» ning hozirgi balansi</h2>
<p class="text-center" style="font-size: xxx-large">
    <?= $model->getTotalBalance() . " ".Yii::t('app','so\'m') ?>
</p>
