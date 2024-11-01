<?php

use common\modules\university\models\Faculty;

/* @var $this soft\web\View */
/* @var $model common\modules\university\models\Faculty */


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faculty'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'attributes' => [
              'id',
              'name_uz',
              'name_ru',
              'name_en',
              'statusBadge:raw',
              'created_at',
              'createdBy.fullname',
              'updated_at',
              'updatedBy.fullname'

        ],
    ]) ?>
