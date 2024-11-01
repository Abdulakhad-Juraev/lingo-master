<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use common\modules\usermanager\models\Balance;

/**
 * @var $this yii\web\View
 * @var $drivers array
 * @var $model Balance
 */
?>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                        'options' => [
                            'autocomplete' => "off"
                        ]
                    ]); ?>
                    <?= $form->field($model, 'user_id')->widget(Select2::class, [
                        'data' => $users,
                        'options' => [
                            'id' => 'mySelect2',
                            'placeholder' => Yii::t('app','Select').' ...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]) ?>
                    <?= $form->field($model, 'money')->textInput() ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <?= Html::submitButton(Yii::t('app','Complete the account'), [
                                'class' => 'btn btn-primary',
                                'id' => 'submit_btn'
                            ]) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="d-flex justify-content-center flex-column" id="ajaxContent">
            </div>
        </div>
    </div>

<?php
$ajaxUrl = Url::to(['/balance/get-balance']);

$unselectEvent = <<<JS
(event)=>{
    console.log('unselect');
    $('#ajaxContent').html('');
}
JS;


$js = <<<JS
$(document).on('beforeSubmit', 'form', function(event) {
    $(this).find('[type=submit]').attr('disabled', true).addClass('disabled');
});

$(document).ready(()=>{
    let val = $('#mySelect2').val()
    if (val) {
        $.ajax({
            url: '{$ajaxUrl}',
            data: {user_id: val},
            type: 'GET',
            success: function(data) {
                $('#ajaxContent').html(data);
            }
        });
    }
    $('#mySelect2').on('select2:select', function (event){
        let id = event.params.data.id;
        $.ajax({
            url: '{$ajaxUrl}',
            data: {user_id: id},
            type: 'GET',
            success: function(data) {
                $('#ajaxContent').html(data);
            }
        });
    });
    $('#mySelect2').on('select2:unselect', function (){
        $('#ajaxContent').html('');
    })
   
})
JS;

$this->registerJs($js);
