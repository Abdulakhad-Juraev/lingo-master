<?php

use common\modules\region\models\Districts;
use common\modules\region\models\Regions;
use common\modules\regionmanager\models\District;
use common\modules\regionmanager\models\Region;
use common\modules\testmanager\models\Test;
use common\modules\university\models\Course;
use common\modules\university\models\Direction;
use common\modules\university\models\Faculty;
use common\modules\university\models\Group;
use common\modules\university\models\JshshirMaskedInput;
use common\modules\university\models\Language;
use common\modules\usermanager\models\Student;
use kartik\date\DatePicker;
use kartik\widgets\DepDrop;
use soft\helpers\Html;
use soft\helpers\Url;
use soft\widget\input\PhoneMaskedInput;
use soft\widget\input\VisiblePasswordInput;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Select2;


/* @var $this soft\web\View */
/* @var $form ActiveForm */
/* @var $model Student */
?>
<div class="card card-outline card-info">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'username')->widget(JshshirMaskedInput::class) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'password')->widget(VisiblePasswordInput::class) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'full_name')->textInput() ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'faculty_id')->widget(Select2::classname(), [
                    'data' => Faculty::map(),
                    'options' => ['placeholder' => 'Tanlang...', 'id' => 'cat-id'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>

            <div class="col-6">
                <?= $form->field($model, 'direction_id')->widget(DepDrop::classname(), [
                    'type' => DepDrop::TYPE_SELECT2,
                    'data' => Direction::getDirections($model->faculty_id),
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'options' => ['id' => 'subcat-id'],
                    'pluginOptions' => [
                        'depends' => ['cat-id'],
                        'placeholder' => t('Select').' ...',
                        'url' => Url::to(['/usermanager/ajax/direction'])
                    ]
                ]); ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'course_id')->widget(Select2::classname(), [
                    'data' => Course::map(),
                    'options' => ['placeholder' => t('Select').' ...', 'id' => 'course-id'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'language_id')->widget(Select2::classname(), [
                    'data' => Language::map(),
                    'options' => ['placeholder' => t('Select').' ...', 'id' => 'language-id'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'educational_type')->widget(Select2::class, [
                    'data' => Test::educationalTypes()
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'educational_form')->widget(Select2::class, [
                    'data' => Test::educationalFrom()
                ]) ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'region_id')->widget(Select2::classname(), [
                    'data' => Region::regions(),
                    'options' => ['placeholder' => t('Select').' ...', 'id' => 'regions-id'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'district_id')->widget(DepDrop::classname(), [
                    'type' => DepDrop::TYPE_SELECT2,
                    'data' => District::getDistricts($model->region_id),
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'options' => ['id' => 'district-id'],
                    'pluginOptions' => [
                        'depends' => ['regions-id'],
                        'placeholder' => t('Select').' ...',
                        'url' => Url::to(['/usermanager/ajax/districts'])
                    ]
                ]); ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'born_date')->widget(DatePicker::classname(), [
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true
                    ]
                ]); ?>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group" style="display: flex;float: right">
                    <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
