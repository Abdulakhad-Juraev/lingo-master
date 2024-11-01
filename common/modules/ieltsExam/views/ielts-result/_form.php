<?php

use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsResult */

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
              'started_at_speaking',
              'expired_at',
              'expired_at_listening',
              'expired_at_reading',
              'expired_at_writing',
              'expired_at_speaking',
              'listening_duration',
              'reading_duration',
              'writing_duration',
              'speaking_duration',
              'correct_answers_listening',
              'correct_answers_reading',
              'listening_score',
              'reading_score',
              'writing_score',
              'speaking_score',
              'step',
              'finished_at',
              'status',
              'created_by',
              'updated_by',
              'price',
              'finished_at_listening',
              'finished_at_writing',
              'finished_at_reading',
              'finished_at_speaking',
        ]
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

