<?php

use frontend\assets\MathXmlViewer;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $subject \backend\modules\testmanager\models\Subject */
/* @var $searchModel backend\modules\testmanager\models\search\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

MathXmlViewer::register($this);

$this->title = 'Olimpiadaga tegishli testlar';
$this->params['breadcrumbs'][] = ['label' => 'Olimpiadalar', 'url' => ['subject/index']];
$this->params['breadcrumbs'][] = $test->name;
$this->params['breadcrumbs'][] = $this->title;

$errors = Yii::$app->session->getFlash('errors');
?>
<?php if (!empty($errors)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card collapsed-card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title text-danger"><i class="fas fa-info"></i> Kiritishda muammo bo'lgan ma'lumotlar</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body collapse">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Number</th>
                            <th>Question</th>
                            <th>Option 1</th>
                            <th>Option 2</th>
                            <th>Option 3</th>
                            <th>Option 4</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($errors as $key => $error): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= htmlspecialchars($error['number'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($error['question'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($error['option_1'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($error['option_2'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($error['option_3'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($error['option_4'], ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="question-index">
    <p>
        <?= Html::a("<i class='fa fa-plus'></i> Test qo'shish ", ['create', 'test_id' => $test->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
        ],
        'condensed' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => '\kartik\grid\ExpandRowColumn',
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function () {
                    return GridView::ROW_COLLAPSED;
                },
                'detailRowCssClass' => 'white-color',
                'expandOneOnly' => true,
                'detail' => function ($model) {
                    return $this->render('_question_detail', ['model' => $model]);
                }
            ],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'width' => '70%'
            ],
            [
                'attribute' => 'status',
                'filter' => [
                    1 => 'Faol',
                    0 => 'Nofaol',
                ],
                'value' => function ($model) {
                    /** @var \backend\modules\testmanager\models\Subject $model */
                    return $model->status ? 'Faol' : 'Nofaol';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
            ],
        ],
    ]); ?>


</div>
