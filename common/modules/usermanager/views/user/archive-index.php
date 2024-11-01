<?php


/* @var $this soft\web\View */
/* @var $searchModel StudentSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use soft\helpers\Url;
use soft\helpers\Html;
use soft\grid\GridView;
use common\models\User;
use common\modules\usermanager\models\search\StudentSearch;
use common\modules\university\models\StatusActiveColumn;

$this->title = Yii::t('app', 'Student');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
$errors = Yii::$app->session->getFlash('errors');
?>
<?php
if (!empty($errors)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card collapsed-card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title text-danger"><i class="fas fa-info"></i> Kiritishda muammo bo'lgan ma'lumotlar
                    </h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <table class="table table-bordered">
                        <tr>
                            <td>№</td>
                            <td>Jshshir</td>
                            <td>Kursi</td>
                            <td>Yo'nalish</td>
                            <td>Tili</td>
                            <td>Ta'lim turi</td>
                            <td>Ta'lim shakli</td>
                            <td>Jinsi</td>
                        </tr>
                        <?php foreach ($errors as $key => $error): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= $error['jshshir'] ?></td>
                                <td><?= $error['course'] ?? '' ?></td>
                                <td><?= $error['direction'] ?? '' ?></td>
                                <td><?= $error['language'] ?? '' ?></td>
                                <td><?= $error['educational_type'] ?? '' ?></td>
                                <td><?= $error['educational_form'] ?? '' ?></td>
                                <td><?= $error['sex'] ?? '' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{back}',
    'toolbarButtons' => [
        'back' => [
            'modal' => false,
            'pjax' => false,
            'cssClass' => 'btn btn-default',
            'content' => Yii::t('site', 'Back'),
            'icon' => 'arrow-left,fas',
            'url' => \soft\helpers\Url::to(['index']),
        ],
    ],
    'columns' => [
        [
            'attribute' => 'username',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->username, ['student/view', 'id' => $model->id], ['data-pjax' => 0]);
            }
        ],
        'full_name',
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
        ],
        [
            'attribute' => 'balance',
            'value' => function (User $model) {
                return $model->getTotalBalance() . " " . Yii::t('app', 'so\'m');
            }
        ],
        'actionColumn' => [
            'width' => '160px',
            'template' => '{view} {update} {delete} {active} ',
            'buttons' => [
                'active' => function ($url, $model, $key) {
                    return StatusActiveColumn::getUserStatuses($model, 'student');
                }
            ],

        ],
    ],
]); ?>
