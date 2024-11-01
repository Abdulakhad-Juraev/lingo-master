<?php

use common\modules\usermanager\models\Balance;
use common\traits\RangeFilterable;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use soft\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\Pjax;

/**
 * @var $searchModel
 * @var $drivers array
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 */
$this->title = Yii::t('app', 'Balance');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
    <div class="card-body">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => SerialColumn::class],

                [
                    'attribute' => 'user_id',
                    'value' => static function (Balance $model) {
                        return "({$model->user_id}) {$model->user->getFullname()}";
                    },
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'user_id',
                        'data' => $drivers,
                        'options' => [
                            'placeholder' => Yii::t('app','Select'). ' ...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]),
                ],
                [
                    'attribute' => 'type',
                    'filter' => Balance::getTypeList(),
                    'value' => static function (Balance $model) {
                        return $model->getTypeName();
                    },
                ],
                'value:sum',
                [
                    'attribute' => 'reason',
                    'filter' => Balance::getReasonList(),
                    'value' => function (Balance $model) {
                        return $model->getReasonName();
                    },
                ],

                [
                    'attribute' => 'created_at',
                    'format' => 'datetime',
                    'filter' => RangeFilterable::getFilter($searchModel)
                ],
                [
                    'class' => ActionColumn::class,
                    'template' => '{view}',
                ],
            ],
        ]) ?>

        <?php Pjax::end(); ?>
    </div>
</div>