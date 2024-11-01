<?php

use yii\widgets\DetailView;
use common\modules\usermanager\models\Balance;

/* @var $model Balance */
/* @var $this yii\web\View */

$this->title = "Balans ID: " . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Balance'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-md-6 d-flex justify-content-center align-items-center">
        <div class="d-flex justify-content-center flex-column">
            <h3 class="text-center"><?=Yii::t('app','Current balance');?></h3>
            <p style="font-size: xxx-large">
                <?= Yii::$app->formatter->asInteger($model->user->getTotalBalance()) ." ".Yii::t('app','so\'m');?>
            </p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'attribute' => 'user_id',
                            'value' => $model->user->getFullname(),
                        ],
                        [
                            'attribute' => 'type',
                            'value' => $model->getTypeName(),
                        ],
                        'value:sum',
                        'total:sum',
                        [
                            'attribute' => 'reason',
                            'value' => $model->getReasonName(),
                        ],
                        'comment',
                        [
                            'attribute' => 'test_id',
                            'format' => 'raw',

                        ],
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>