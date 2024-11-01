<?php


/* @var $this soft\web\View */
/* @var $model common\modules\ieltsExam\models\IeltsResult */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ielts Results'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'attributes' => [
              'id', 
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
              'created_at', 
              'updated_at', 
              'price', 
              'finished_at_listening', 
              'finished_at_writing', 
              'finished_at_reading', 
              'finished_at_speaking', 
'created_at',
'createdBy.fullname',
'updated_at',
'updatedBy.fullname'        ],
    ]) ?>
<?php

use common\modules\testmanager\models\TestResultItem;
use kartik\grid\SerialColumn;
use yii\helpers\Html;


$this->title = Yii::t('site', 'IELTS results').'#' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', 'IELTS results'), 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new \yii\data\ActiveDataProvider([
    'query' => $model->getIeltsResultItems()->with(['question', 'userAnswer']),
    'pagination' => [
        'defaultPageSize' => 100
    ]
]);
\frontend\assets\MathXmlViewer::register($this);

?>
<div class="test-result-view">


    <?= \kartik\grid\GridView::widget([

        'dataProvider' => $dataProvider,
        'pjax' => false,
        'condensed' => true,
        'panel' => [
            'type' => 'primary',
            'heading' => '<i class="glyphicon glyphicon-list"></i>'.Yii::t('site', 'Test results'),
        ],
        'columns' => [
            [
                'class' => SerialColumn::class,
            ],
            [
                'label' => "Savol matni",
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var TestResultItem $model */
                    if ($model->question) {
                        return Html::a($model->question->title, ['question/view', 'id' => $model->question_id], ['data-pjax' => 0]);
                    } else {
                        return Html::tag('i', 'Savol topilmadi!', ['class' => 'text-danger']);
                    }
                }
            ],
            'question.title:raw',
            'userAnswerText:raw',
            'answerIcon:raw'
        ]


    ]) ?>

</div>

