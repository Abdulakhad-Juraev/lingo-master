<?php


/* @var $model common\modules\testmanager\models\Test */

/* @var $this yii\web\View */

use common\modules\testmanager\models\Test;
use soft\widget\bs4\DetailView;
use yii\web\YiiAsset;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Test'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'name',
        'statusBadge:raw',
        'number_tries',
        [
            'attribute' => 'is_free',
            'format' => 'raw',
            'value' => function (Test $model) {
                return $model->is_free ? $model->getNameAndPrice() : '';
            }
        ],
        [
            'attribute' => 'price',
            'format' => 'raw',
            'value' => function (Test $model) {
                return $model->price ? getFormattedPrice() : '';
            }
        ],
        [
            'attribute' => 'started_at',
            'format' => 'raw',
            'value' => function (Test $model) {
                return Yii::$app->formatter->asDatetime($model->started_at, 'php:Y-m-d H:i:s');
            }
        ],
        [
            'attribute' => 'finished_at',
            'format' => 'raw',
            'value' => function (Test $model) {
                return Yii::$app->formatter->asDatetime($model->finished_at, 'php:Y-m-d H:i:s');
            }
        ],

        'duration',
        'tests_count',
        [
            'attribute' => 'test_type',
            'format' => 'raw',
            'value' => function (Test $model) {
                return $model->test_type ? $model->getTestTypeName() : '';
            }
        ],
        'show_answer',
        'old_test_count',
        'current_test_count',
        [
            'attribute' => 'subject_id',
            'format' => 'raw',
            'value' => function (Test $model) {
                return $model->subject ? $model->subject->name : '';
            }
        ],
        [
            'attribute' => 'direction_id',
            'format' => 'raw',
            'value' => function (Test $model) {
                return $model->direction ? $model->direction->name : '';
            }
        ],
        [
            'attribute' => 'course_id',
            'format' => 'raw',
            'value' => function (Test $model) {
                return $model->course ? $model->course->name : '';
            }
        ],
        [
            'attribute' => 'semester_id',
            'format' => 'raw',
            'value' => function (Test $model) {
                return $model->semester ? $model->semester->name : '';
            }
        ],
        [
            'attribute' => 'control_type_id',
            'format' => 'raw',
            'value' => function (Test $model) {
                return $model->control_type_id ? $model->getControlTypeName() : '';
            }
        ],
        [
            'attribute' => 'educational_form',
            'format' => 'raw',
            'value' => function (Test $model) {
                return $model->educationalFromName() ?? 'N/A';
            }
        ],
        [
          'attribute' => 'educational_type',
          'format' => 'raw',
            'value' => function (Test $model) {
                return $model->educationalTypeName() ?? 'N/A';
            }
        ],
        [
            'attribute' => 'language_id',
            'format' => 'raw',
            'value' => function (Test $model) {
                return $model->language ? $model->language->name : '';
            }
        ],

    ],
]) ?>
