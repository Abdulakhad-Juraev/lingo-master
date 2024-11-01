<?php use common\modules\auth\models\AuthItem;

/** @var AuthItem $item */

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;

$form = ActiveForm::begin(); ?>
    <div class="panel panel-default">
        <div class="panel-heading"><h4><?=$model->name?></h4></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($item, 'name')->textInput() ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($item, 'description')->textInput() ?>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>