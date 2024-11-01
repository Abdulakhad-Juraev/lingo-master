<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsResultItem */
?>
<div class="ielts-result-item-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'result_id',
            'question_id',
            'user_answer_id',
            'original_answer_id',
            'is_correct',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
            'is_used',
            'type_id',
            'input_type',
            'value:ntext',
        ],
    ]) ?>

</div>
