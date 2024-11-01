<?php


/* @var $this soft\web\View */

/* @var $model common\modules\usermanager\models\Student */


use common\modules\usermanager\models\Student;

use soft\helpers\PhoneHelper;
use soft\widget\bs4\DetailView;

$this->title = $model->firstname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->full_name;
?>
<style>
    .card.card-primary {
        margin-bottom: 0;
    }
</style>
<?= $this->render('_tab-menu', ['model' => $model]) ?>
<div class="card card-outline card-info ">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'username',
                'format' => 'raw',
                'value' => function ($model) {
                    return "+998 " . PhoneHelper::formatPhoneNumber($model->username);
                },
            ],
            'full_name',

            'auth_key',
            [
                'attribute' => 'course_id',
                'format' => 'raw',
                'value' => function (Student $model) {
                    return $model->course ? $model->course->name : '';
                }
            ],
            [
                'attribute' => 'faculty_id',
                'format' => 'raw',
                'value' => function (Student $model) {
                    return $model->faculty ? $model->faculty->name : '';
                }
            ],
            [
                'attribute' => 'direction_id',
                'format' => 'raw',
                'value' => function (Student $model) {
                    return $model->direction ? $model->direction->name : '';
                }
            ],
            [
                'attribute' => 'language_id',
                'format' => 'raw',
                'value' => function (Student $model) {
                    return $model->language ? $model->language->name : '';
                }
            ],
            [
                'attribute' => 'region_id',
                'format' => 'raw',
                'value' => function (Student $model) {
                    return $model->region ? $model->region->name_uz : '';
                }
            ],
            [
                'attribute' => 'district_id',
                'format' => 'raw',
                'value' => function (Student $model) {
                    return $model->district ? $model->district->name_uz : '';
                }
            ],
            [
                'attribute' => 'educational_type',
                'value' => function (Student $model) {
                    return $model->educationalTypeName();
                }
            ],
            [
                'attribute' => 'educational_form',
                'value' => function (Student $model) {
                    return $model->educationalFormName();
                }
            ],
            'born_date:datetime',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function (Student $model) {
                    return $model->getStatusBadge();
                }
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>


</div>
