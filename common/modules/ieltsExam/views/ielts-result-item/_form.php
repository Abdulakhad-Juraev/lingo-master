<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsResultItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ielts-result-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'result_id')->textInput() ?>

    <?= $form->field($model, 'question_id')->textInput() ?>

    <?= $form->field($model, 'user_answer_id')->textInput() ?>

    <?= $form->field($model, 'original_answer_id')->textInput() ?>

    <?= $form->field($model, 'is_correct')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'is_used')->textInput() ?>

    <?= $form->field($model, 'type_id')->textInput() ?>

    <?= $form->field($model, 'input_type')->textInput() ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
