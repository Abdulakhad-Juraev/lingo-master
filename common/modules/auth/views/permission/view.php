<?php


/* @var $this soft\web\View */
/* @var $model */
/** @var AuthItem $dataProvider */

use common\modules\auth\models\AuthItem;
use soft\grid\GridView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permission'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerAjaxCrudAssets();
?>
<?=
GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => true,
            'url'=>['create-permission','name'=>$model->name, 'role' => 'modal-remote',],
            'visible' => canRoles(['admin']),
        ]
    ],
    'columns' => [
        'name',
        'description',
    ],
]); ?>
