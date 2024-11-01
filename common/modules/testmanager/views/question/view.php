<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\testmanager\models\Question */

\yii\web\YiiAsset::register($this);
\frontend\assets\MathXmlViewer::register($this);

$this->title = "#" . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Olimpiadalar', 'url' => ['test/index']];
$this->params['breadcrumbs'][] = ['label' => $model->test->name ?? 'Olimpiada', 'url' => ['question/index', 'test_id' => $model->test_id]];
$this->params['breadcrumbs'][] = $this->title;


$dataProvider = new \yii\data\ActiveDataProvider([
    'query' => $model->getOptions(),
]);


?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12">
                <p>
                    <?= Html::a('<i class="fas fa-pencil-alt"></i> Tahrirlash', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('<i class="fas fa-trash-alt"></i> O\'chirish', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'title:raw',
                        'subject.name',
                        'created_at:datetime',
                        'updated_at:datetime',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row mt-2">
            <div class="col-12">
                <h3 align="center">Variantlar</h3>
                <hr>
                <?= \yii\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'text:raw:Variant',
                        "isAnswerIcon:raw:To'g'ri / Xato"
                    ]
                ]) ?>
            </div>
        </div>
    </div>
</div>