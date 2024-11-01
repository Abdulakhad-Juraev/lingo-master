<?php

use common\modules\ieltsExam\models\IeltsQuestionGroup;

/* @var $this soft\web\View */
/* @var $searchModel common\modules\ieltsExam\models\search\IeltsQuestionGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ielts Question Groups');
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
    <?= \soft\grid\GridView::widget([
        'id' => 'crud-datatable',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel, 
        'toolbarTemplate' => '{create}{refresh}',
        'toolbarButtons' => [
            'create' => [
                /** @see soft\widget\button\Button for other configurations */
                'modal' => true,
            ]
        ],
        'columns' => [
            'exam_id',
            'content',
            'audio',
            'section',
            'type_id',
            'status',
            'actionColumn' => [
                'viewOptions' => [
                    'role' => 'modal-remote',
                ],
                'updateOptions' => [
                    'role' => 'modal-remote',
                ],
            ],
        ],
        ]); ?>
    