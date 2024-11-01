<?php

use common\modules\testmanager\widgets\CKEditorForDynamicForm;
use common\modules\toeflExam\models\ToeflOption;
use common\modules\toeflExam\models\ToeflQuestion;
use kartik\form\ActiveForm;
use mihaildev\elfinder\ElFinder;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ToeflQuestion */
/* @var $modelsOption ToeflOption */

\yii\jui\JuiAsset::register($this);

$host = Yii::$app->request->hostInfo;
$wirisJsUrl = $host . '/ckeditor/plugins/ckeditor_wiris/plugin.js';
$this->registerJs("CKEDITOR.plugins.addExternal('ckeditor_wiris', '" . $wirisJsUrl . "', '');");

$ckeditorOptions = ElFinder::ckeditorOptions('elfinder', [
    'height' => '80px',
    'allowedContent' => true,
    'extraPlugins' => 'ckeditor_wiris',
    'toolbarGroups' => [
        ['name' => 'undo'],
        ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
        ['name' => 'colors'],
        ['name' => 'links', 'groups' => ['insert']],
        ['name' => 'others', 'groups' => ['others']],
        ['name' => 'ckeditor_wiris']
    ]
]);

?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="card">
    <div class="card-body">
        <?= $form->field($model, 'value')
            ->widget(CKEditorForDynamicForm::className(), ['editorOptions' => $ckeditorOptions, 'options' => ['autofocus' => true, 'tabindex' => 1]])
            ->label('Question')
        ?>
        <div class="col-md-12" style="margin-top: 10px">
            <?= $form->field($model, 'status')->checkbox([], true)->label('Faol') ?>
        </div>
    </div>
</div>
<hr>
<h5 align="center" class="text-muted bg-warning"><?= t('Toefl Reading Options') ?></h5>
<hr>
<div class="card">
    <div class="card-body">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper',
            'widgetBody' => '.container-items',
            'widgetItem' => '.item',
            'limit' => 4,
            'min' => 1,
            'insertButton' => '.add-item',
            'deleteButton' => '.remove-item',
            'model' => $modelsOption[0],
            'formId' => 'dynamic-form',
            'formFields' => [
                'text',
                'isAnswer',
            ],
        ]); ?>
        <div class="row container-items">

            <?php foreach ($modelsOption as $index => $modelOption): ?>
                <div class="col-md-6 item">
                    <div class="">
                        <div class="">
                            <h5 class="text-info" align="center">
                                <button title="Ushbu variantni o'chirish" style="margin: 0 5px;" type="button"
                                        class="float-right remove-item btn btn-danger btn-xs"><i
                                            class="fa fa-trash"></i>
                                </button>
                                <button title="Yangi variant qo'shish" style="margin: 0 5px;" type="button"
                                        class="float-right add-item btn btn-success btn-xs"><i
                                            class="fa fa-plus"></i>
                                    Variant qo'shish
                                </button>
                            </h5>
                            <div class="clearfix"></div>
                        </div>
                        <?php
                        if (!$modelOption->isNewRecord) {
                            echo Html::activeHiddenInput($modelOption, "[{$index}]id", ['class' => 'id-hidden-input']);
                        }
                        ?>
                        <div class="radio-area">
                            <?= Html::radio('is_correct', $modelOption->is_correct, ['label' => "To'g'ri javob", 'value'
                            => $index, 'class' => "radio-selection", 'title' => "Ushbu variantni to'g'ri javob sifatida belgilash"]) ?>
                        </div>
                        <?php $tabindex = $index + 2 ?>
                        <?= $form->field($modelOption, "[{$index}]text")->widget(CKEditorForDynamicForm::className(), ['editorOptions' => $ckeditorOptions, 'options' => ['tabindex' => $tabindex]])->label(false) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php DynamicFormWidget::end(); ?>

        <div class="form-group">
            <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<?php

$js = <<<JS
    function reArrangeValues(){
         $('.dynamicform_wrapper .radio-selection').each(function(index){
            $(this).val(index);
        });
        $('.dynamicform_wrapper textarea').each(function(index){
            let tabindexvalue = index + 2;
            $(this).attr('tabindex', tabindexvalue);
        });
    }

    $(document).on('click', '.add-item', function(e){
        setTimeout(function(){
            reArrangeValues();
        }, 100);
    });

    $(document).on('click', '.remove-item', function(e){
        setTimeout(function(){
            reArrangeValues();
        }, 100);
    });

    $('.dynamicform_wrapper').on('beforeDelete', function(e, item) {
        if (!confirm('Haqiqatan ham o\'chirishni istaysizmi?')) {
            return false;
        }
        return true;
    });

    $('.dynamicform_wrapper').on('limitReached', function(e, item) {
        alert('Bundan ortiq variant qo`shib bo`lmaydi!');
    });

    reArrangeValues();
JS;

$this->registerJs($js);

?>
