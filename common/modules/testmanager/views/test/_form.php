<?php

use common\modules\testmanager\models\Subject;
use common\modules\testmanager\models\Test;
use common\modules\university\models\Course;
use common\modules\university\models\Direction;
use common\modules\university\models\Language;
use common\modules\university\models\Semester;
use soft\widget\kartik\DateTimePicker;
use soft\widget\kartik\Select2;
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model Test*
 */

?>
<?php $form = ActiveForm::begin(); ?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'duration')->input('number') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'price')->input('number') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'tests_count')->input('number') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'current_test_count')->input('number') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'old_test_count')->input('number') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'subject_id')->widget(Select2::class, [
                    'data' => Subject::map()
                ]) ?>                </div>
            <div class="col-md-6">
                <?= $form->field($model, 'test_type')->widget(Select2::class, [
                    'data' => Test::testTypes(),
                    'options' => ['id' => 'test-test_type']
                ]) ?>
            </div>
        </div>
        <div class="row" id="direction">
            <div class="col-md-6">
                <?= $form->field($model, 'direction_id')->widget(Select2::class, [
                    'data' => Direction::map()
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'course_id')->widget(Select2::class, [
                    'data' => Course::map()
                ]) ?>
            </div>
        </div>
        <div class="row" id="semester">
            <div class="col-md-6">
                <?= $form->field($model, 'educational_form')->widget(Select2::class, [
                    'data' => Test::educationalFrom()
                ]) ?>
            </div>
            <!--            <div class="col-md-6">-->
            <!--                --><?php //= $form->field($model, 'semester_id')->widget(Select2::class, [
            //                    'data' => Semester::map()
            //                ]) ?>
            <!--            </div>-->
            <div class="col-md-6">
                <?= $form->field($model, 'language_id')->widget(Select2::class, [
                    'data' => Language::map()
                ]) ?>
            </div>
        </div>
        <div class="row" id="control">
            <div class="col-md-6">
                <?= $form->field($model, 'control_type_id')->widget(Select2::class, [
                    'data' => Test::controlTypes()
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'educational_type')->widget(Select2::class, [
                    'data' => Test::educationalTypes()
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'number_tries')->input('number') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'maximum_score')->input('number') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'started_at')->widget(DateTimePicker::class,
                    ['data' => Subject::map()
                    ]) ?>                </div>
            <div class="col-md-6">
                <?= $form->field($model, 'finished_at')->widget(DateTimePicker::class) ?>
            </div>
        </div>

        <?= $form->field($model, 'is_free')->checkbox() ?>
        <?= $form->field($model, 'status')->checkbox() ?>
        <?= $form->field($model, 'show_answer')->checkbox() ?>

        <div class="col-12">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php
    $js = <<<JS
$(document).ready(function() {
    function toggleFields() {
        var type_id = $('#test-test_type').val();
        if (type_id == 1) {
            $('#semester, #direction, #educational_form, #control').hide();
        } else {
            $('#semester, #direction, #control, #educational_form').show();
        }
    }
    $('#test-test_type').on('change', toggleFields);
    toggleFields();
});
JS;
    $this->registerJs($js);
    ?>




