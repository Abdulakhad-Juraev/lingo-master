<?php

use common\models\Settings;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Setting */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sozlamalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['update'] = Html::a('<i class="fa fa-pencil"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
?>
<div class="card">
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'info',
                'value',
                [
                    'label' => 'Keshdagi qiymati',
                    'value' => static function (Settings $model) {
                        return Settings::get($model->name);
                    }
                ],
                'created_at:datetime',
                'updated_at:datetime',
                [
                    'attribute' => 'updated_by',
                    'value' => static function (Settings $model) {
                        return $model->updatedBy->fullname ?? '-';
                    }
                ],
            ],
        ]) ?>
    </div>
</div>
