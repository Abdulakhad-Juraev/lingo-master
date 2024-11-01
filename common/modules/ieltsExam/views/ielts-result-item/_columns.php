<?php

/* @var $this \yii\web\View */

use common\modules\ieltsExam\models\IeltsResultItem;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'question_id',
        'format' => 'raw',
        'value' => function (IeltsResultItem $model) {
            return $model->question->value;
        }
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'user_answer_id',
        'format' => 'raw',
        'contentOptions' => ['class' => 'text-center'],
        'headerOptions' => ['class' => 'text-center'],
        'hAlign' => 'center',
        'value' => function (IeltsResultItem $model) {
            return $model->userAnswer ? $model->userAnswer->text : 'No Answer';
        }
    ],
//    [
//        'class' => '\kartik\grid\DataColumn',
//        'attribute' => 'original_answer_id',
//        'format' => 'raw',
//        'value' => function (IeltsResultItem $model) {
//            return $model->originalAnswer->isCorrectIcon;
//        }
//    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'is_correct',
        'format' => 'raw',
        'width' => '80px',
        'contentOptions' => ['class' => 'text-center'],
        'headerOptions' => ['class' => 'text-center'],
        'hAlign' => 'center',
        'value' => function ($model) {
            return $model->is_correct ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>';
        }
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'type_id',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'input_type',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'format' => 'raw',
        'attribute' => 'value',
    ],
    //    [
    //        'class' => 'kartik\grid\ActionColumn',
    //        'dropdown' => false,
    //        'vAlign' => 'middle',
    //        'urlCreator' => function ($action, $model, $key, $index) {
    //            return Url::to([$action, 'id' => $key]);
    //        },
    //        'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
    //        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
    //        'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
    //            'data-confirm' => false, 'data-method' => false,// for overide yii data api
    //            'data-request-method' => 'post',
    //            'data-toggle' => 'tooltip',
    //            'data-confirm-title' => 'Are you sure?',
    //            'data-confirm-message' => 'Are you sure want to delete this item'],
    //    ],

];   