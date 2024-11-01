<?php


/* @var $this soft\web\View */

/* @var $model common\models\CompanyInfo */

use common\models\CompanyInfo;
use soft\helpers\Html;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Company Info'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \soft\widget\bs4\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'attribute' => 'logo',
            'format' => 'raw',
            'value' => function (CompanyInfo $model) {
                return Html::img($model->getFileUrl(), ['style' => 'width:100px;']);
            }
        ],
        'instagram',
        'telegram',
        'twitter',
        'youtube',
        'facebook',
        'statusBadge:raw',
    ],
]) ?>
