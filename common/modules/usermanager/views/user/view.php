<?php


/* @var $this soft\web\View */

/* @var $model common\modules\usermanager\models\User */


use common\modules\usermanager\models\User;

use soft\helpers\PhoneHelper;
use soft\widget\bs4\DetailView;

$this->title = $model->firstname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                'attribute' => 'region_id',
                'format' => 'raw',
                'value' => function (User $model) {
                    return $model->region ? $model->region->name_uz : '';
                }
            ],
            [
                'attribute' => 'district_id',
                'format' => 'raw',
                'value' => function (User $model) {
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
