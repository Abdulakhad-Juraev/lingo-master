<?php


/* @var $this soft\web\View */
/* @var $searchModel StudentSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use common\modules\university\models\Course;
use common\modules\university\models\Faculty;
use common\modules\usermanager\models\Student;
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
    'toolbarTemplate' => '{create} {import-student} {update-student} {student-delete} {student-archive}',
    'toolbarButtons' => [
        'import-student' => [
            'modal' => false,
            'pjax' => false,
            'cssClass' => 'btn btn-default',
            'title' => Yii::t('site', 'Import'),
            'url' => Url::to(['import-student']),
            'icon' => 'download,fas'
        ],
        'update-student' => [
            'modal' => false,
            'pjax' => false,
            'cssClass' => 'btn btn-default',
            'title' => Yii::t('site', 'Qayta yuklash'),
            'url' => \soft\helpers\Url::to(['update-student']),
            'icon' => 'sync-alt,fas'
        ],
        'create' => [
            'modal' => false,
            'pjax' => false,
            'cssClass' => 'btn btn-info',
            'icon' => 'user-plus,fas'
        ],
        'student-delete' => [
            'modal' => false,
            'pjax' => false,
            'cssClass' => 'btn btn-default',
            'title' => Yii::t('site', 'Delete'),
            'icon' => 'trash,fas',
            'url' => \soft\helpers\Url::to(['student-delete']),
        ],
        'student-archive' => [
            'modal' => false,
            'pjax' => false,
            'cssClass' => 'btn btn-default',
            'title' => Yii::t('site', 'Archive'),
            'icon' => 'box,fas',
            'url' => \soft\helpers\Url::to(['archive-index']),
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
            'attribute' => 'faculty_id',
            'format' => 'raw',
            'filter' => Faculty::map(),
            'value' => function (Student $model) {
                return $model->faculty ? $model->faculty->name : '';
            }
        ],
        [
            'attribute' => 'course_id',
            'format' => 'raw',
            'filter' => Course::map(),
            'value' => function (Student $model) {
                return $model->course ? $model->course->name : '';
            }
        ],
        [
            'attribute' => 'created_at',
            'filterType' => GridView::FILTER_DATE_RANGE,
            'filterWidgetOptions' => [
                'model' => $searchModel,
                'convertFormat' => true,
                'presetDropdown' => true,
                'includeMonthsFilter' => true,
                'pluginOptions' => [
                    'locale' => [
                        'format' => 'Y-m-d'
                    ]
                ]
            ],
            'value' => function (Student $model) {
                return date('d.m.Y H:i', $model->created_at);
            },

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
