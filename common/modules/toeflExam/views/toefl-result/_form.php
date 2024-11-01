<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\modules\toeflExam\models\ToeflResult */

?>


    <?php $form = ActiveForm::begin(); ?>

    <?= Form::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
                  'user_id',
              'exam_id',
              'started_at',
              'started_at_listening',
              'started_at_reading',
              'started_at_writing',
              'expire_at',
              'expire_at_listening',
              'expire_at_reading',
              'expire_at_writing',
              'reading_duration',
              'writing_duration',
              'listening_duration',
              'correct_answers_listening',
              'correct_answers_reading',
              'correct_answers_writing',
              'price',
              'finished_at',
              'finished_at_listening',
              'finished_at_reading',
              'finished_at_writing',
              'step',
              'status',
              'created_by',
              'updated_by',
              'listening_score',
              'reading_score',
              'writing_score',
        ]
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

