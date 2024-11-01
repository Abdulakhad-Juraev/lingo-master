<?php


/* @var $this soft\web\View */
/* @var $model common\modules\university\models\Group */

use common\modules\university\models\Course;
use common\modules\university\models\Direction;
use common\modules\university\models\Group;
use common\modules\university\models\Language;
use soft\widget\bs4\DetailView;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'attribute' => 'direction_id',
            'format' => 'raw',
            'filter' => Direction::map(),
            'value' => function (Group $model) {
                return $model->direction ? $model->direction->name : '';
            }
        ],
        'status',
        [
            'attribute' => 'language_id',
            'format' => 'raw',
            'filter' => Language::map(),
            'value' => function (Group $model) {
                return $model->language ? $model->language->name : '';
            }
        ],
        [
            'attribute' => 'course_id',
            'format' => 'raw',
            'filter' => Course::map(),
            'value' => function (Group $model) {
                return $model->course ? $model->course->name : '';
            }
        ],
        'created_at',
        'createdBy.fullname',
        'updated_at',
        'updatedBy.fullname'],
]) ?>
