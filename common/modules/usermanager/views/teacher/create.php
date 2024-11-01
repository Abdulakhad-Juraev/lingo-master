<?php


/* @var $this soft\web\View */
/* @var $model \common\modules\usermanager\models\Teacher */

$this->title = $this->title = Yii::t('site', 'Create a new');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Teachers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>