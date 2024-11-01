<?php


/* @var $this soft\web\View */
/* @var $model common\modules\usermanager\models\Teacher */


use common\modules\usermanager\models\Teacher;

use soft\helpers\PhoneHelper;
use soft\widget\bs4\DetailView;

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => t('app', 'Teachers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .card.card-primary{
        margin-bottom: 0;
    }
</style>
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
                'jshshir',
                'auth_key',
                [
                    'attribute' => 'faculty_id',
                    'format' => 'raw',
                    'value' => function (Teacher $model) {
                        return $model->faculty ? $model->faculty->name : '';
                    }
                ],
                [
                    'attribute' => 'department_id',
                    'format' => 'raw',
                    'value' => function (Teacher $model) {
                        return $model->department ? $model->department->name : '';
                    }
                ],
                [
                    'attribute' => 'region_id',
                    'format' => 'raw',
                    'value' => function (Teacher $model) {
                        return $model->region ? $model->region->name_uz : '';
                    }
                ],
                [
                    'attribute' => 'district_id',
                    'format' => 'raw',
                    'value' => function (Teacher $model) {
                        return $model->district ? $model->district->name_uz : '';
                    }
                ],
                'born_date:datetime',
                'statusBadge:raw',
                'created_at',
                'updated_at',
            ],
        ]) ?>


</div>
