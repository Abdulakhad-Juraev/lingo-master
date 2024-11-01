<?php


/* @var $this soft\web\View */
/* @var $model common\modules\university\models\Department */

use common\modules\university\models\Department;
use common\modules\university\models\Faculty;
use soft\widget\bs4\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Department'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
              'id',
              'name_uz',
              'name_ru',
              'name_en',

            [
                'attribute' => 'faculty_id',
                'format' => 'raw',
                'filter' => Faculty::map(),
                'value' => function (Department $model) {
                    return $model->faculty ? $model->faculty->name : '';
                }
            ],
              'statusBadge:raw',
'created_at',
'createdBy.fullname',
'updated_at',
'updatedBy.fullname'        ],
    ]) ?>
