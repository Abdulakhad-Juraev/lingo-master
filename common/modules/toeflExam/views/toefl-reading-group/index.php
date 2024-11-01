<?php

/* @var $this soft\web\View */
/* @var $searchModel common\modules\toeflExam\models\search\ToeflReadingGroupSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use common\modules\toeflExam\models\ToeflReadingGroup;
use soft\grid\GridView;
use soft\helpers\Url;
use yii\helpers\Html;
use yii\helpers\StringHelper;

$this->title = Yii::t('app', 'Toefl Reading Groups');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?= $this->render('@common/views/menu/_tab-menu', ['model' => $group]) ?>
<?= GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => true,
            'url' => Url::to(['toefl-reading-group/create', 'id' => $group->id, 'data-pjax' => '0'])
        ]
    ],
    'columns' => [
        [
            'attribute' => 'text',
            'format' => 'raw',
            'width' => '800px',
            'value' => function (ToeflReadingGroup $model) {
                return Html::a(StringHelper::truncateWords($model->text, 50),
                    ['toefl-reading-option/index', 'id' => $model->id],
                    ['data-pjax' => 0]
                );
            },
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'width' => '70px',
            'value' => 'statusBadge',
            'filter' => ToeflReadingGroup::statuses()
        ],
        'actionColumn' => [
            'template' => '{view} {update} {delete}',
            'viewOptions' => [
                'role' => 'modal-remote => false',
            ],
            'updateOptions' => [
                'role' => 'modal-remote => false',
            ],
        ],
    ],
]); ?>
    