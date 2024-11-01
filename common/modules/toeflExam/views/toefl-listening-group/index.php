<?php

use common\modules\toeflExam\models\ToeflListeningGroup;
use soft\helpers\Html;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\toeflExam\models\search\ToeflListeningGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Toefl Listening Groups');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= $this->render('@common/views/menu/_tab-menu', ['model' => $group]) ?>

<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => false,
            'url' => \soft\helpers\Url::to(['toefl-listening-group/create', 'id' => $group->id])
        ]
    ],
    'columns' => [

        [
            'attribute' => 'audio',
            'format' => 'raw',
            'width' => '320px',
            'value' => function (ToeflListeningGroup $conversationToefl) {
                return \yii\helpers\Html::tag('audio', '', [
                    'controls' => true,
                    'src' => $conversationToefl->audioUrl,
                ]);
            }
        ],
        [
            'width' => '220px',
            'attribute' => 'type_id',
            'format' => 'raw',
            'value' => function (ToeflListeningGroup $model) {
                return Html::a($model->testTypeName() . ' Section',
                    ['toefl-listening-option/index', 'id' => $model->id],
                    ['data-pjax' => 0]
                );
            },
            'filter' => ToeflListeningGroup::testTypes()
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'width' => '120px',
            'value' => 'statusBadge',
            'filter' => ToeflListeningGroup::statuses()
        ],
        [
            'class' => 'soft\grid\ActionColumn',
            'template' => '{view} {update} {delete} {option}',
            'buttons' => [
                'option' => function ($url, $model, $key) {
                    return a('<i class="fa fa-question-circle"></i>', to(['toefl-listening-option/create', 'id' => $model->id]),
                    );
                },
            ],
        ],

    ],
]); ?>
