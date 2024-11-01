<?php

use common\models\Settings;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sozlamalar';
$this->params['breadcrumbs'][] = $this->title;
$this->params['other'] = Html::a('<i class="fa fa-broom mr-2"></i> Keshni tozalash', ['clear-cache'], ['class' => 'btn btn-sm btn-outline-danger'])
?>
<div class="card">
    <div class="card-body">
        <?php Pjax::begin(); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => SerialColumn::class],

                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => static function (Settings $model) {
                        return Html::a($model->name, [
                            'settings/view',
                            'id' => $model->id
                        ], [
                            'data-pjax' => 0
                        ]);
                    },
                ],
                'info:ntext',
                [
                    'attribute' => 'type',
                    'value' => static function (Settings $settings) {
                        return $settings->getTypeName();
                    }
                ],
                [
                    'attribute' => 'value',
                    'value' => static function (Settings $settings) {
                        return $settings->type === Settings::TYPE_STRING ? StringHelper::truncate($settings->value, 50) : $settings->value;
                    }
                ],
                [
                    'class' => ActionColumn::class,
                    'template' => "{view} {update}"
                ],
            ],
        ]) ?>
        <?php Pjax::end(); ?>
    </div>
</div>
