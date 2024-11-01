<?php

use common\modules\university\models\Course;
use common\modules\university\models\Department;
use common\modules\university\models\Direction;
use common\modules\university\models\Language;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\modules\university\models\Group */

?>


<?php $form = ActiveForm::begin(); ?>

<?= Form::widget([
    'model' => $model,
    'form' => $form,
    'attributes' => [
        'name',
        'direction_id:dropdownList' => [
            'items' => Direction::map(),
            'options' => [
                'prompt' => 'Yo\'nalishni tanlang...'
            ]
        ],
        'language_id:dropdownList' => [
            'items' => Language::map(),
            'options' => [
                'prompt' => 'Yo\'nalishni tanlang...'
            ]
        ],
        'course_id:dropdownList' => [
            'items' => Course::map(),
            'options' => [
                'prompt' => 'Kursni tanlang...'
            ]
        ],
        'status:status',
    ]
]); ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
</div>

<?php ActiveForm::end(); ?>

