<?php

use common\modules\ieltsExam\models\IeltsQuestions;

/** @var $model IeltsQuestions */


$options = $model->ieltsOptions;
?>
<div class="pr-2 pl-2">
    <p class="info"><b><?= t('Options') ?></b></p>
    <table class="table table-striped table-sm">
        <?php foreach ($options as $option): ?>
            <tr>
                <td style="width: 5%; text-align: center">
                    <?= $option->IsCorrectIcon ?>
                </td>
                <td>
                    <?= Yii::$app->formatter->asRaw($option->text) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>