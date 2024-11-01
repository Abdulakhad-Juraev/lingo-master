<?php

use johnitvn\ajaxcrud\BulkButtonWidget;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\ieltsExam\models\search\IeltsResultItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = t('Ielts result items');
$this->params['breadcrumbs'][] = ['label' => t('Ielts result'), 'url' => ['ielts-result/index']];
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="ielts-result-item-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'columns' => require(__DIR__ . '/_columns.php'),
            'toolbar' => [
                ['content' =>
                    '{toggleData}' .
                    '{export}'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'secondary',
                'heading' => '<i class="glyphicon glyphicon-list"></i>' . t('Ielts result items'),
                    '<div class="clearfix"></div>',
            ]
        ]) ?>
    </div>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "",
]) ?>
<?php Modal::end(); ?>
