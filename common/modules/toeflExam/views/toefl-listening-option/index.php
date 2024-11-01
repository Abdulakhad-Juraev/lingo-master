<?php

use common\modules\toeflExam\models\EnglishExam;
use soft\grid\GridView;
use soft\helpers\Html;
use soft\widget\bs3\TabMenu;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\toeflExam\models\search\ToeflListeningGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model EnglishExam */

$this->title = t('Toefl Listening Options');
$this->params['breadcrumbs'][] = ['label' => t('Toefl Listening Groups'), 'url' => ['toefl-listening-group/index', 'id' => $model->exam->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= TabMenu::widget(
    ['items' => [
        [
            'label' => t('Back'),
            'url' => ['toefl-listening-group/index', 'id' => $model->exam->id, 'data-pjax' => '0',],
            'icon' => 'arrow-left,fas',
            'color' => 'default',
            'active' => in_array(
                Yii::$app->controller->route, [
                    'toefl-exam/toefl-listening-option/index'
                ]
            ),
        ],
    ]
    ]) ?>
<?= GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => false,
            'url' => ['toefl-listening-option/create', 'id' => $model->id, ],
        ]
    ],
    'columns' => [
        [
            'class' => '\kartik\grid\ExpandRowColumn',
            'attribute' => 'value',
            'format' => 'raw',
            'value' => function () {
                return GridView::ROW_COLLAPSED;
            },
            'detailRowCssClass' => 'white-color',
            'expandOneOnly' => true,
            'detail' => function ($model) {
                return $this->render('_option-detail', ['model' => $model]);
            }
        ],
        [
            'attribute' => 'value',
            'label' => 'Questions',
            'format' => 'raw',
            'value' => function ($model) {
                return "Question #" . $model->value;
            }
        ],
        'actionColumn' => [
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="fa fa-pen"></i>', ['toefl-listening-option/update', 'id' => $model->id], [
                        'data-pjax' => '0',
                    ]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fa fa-trash"></i>', ['toefl-listening-option/delete', 'id' => $model->id], [
                        'title' => Yii::t('app', 'Delete'),
                        'aria-label' => Yii::t('app', 'Delete'),
                        'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ]);
                },

            ]
        ],

    ],
]); ?>
