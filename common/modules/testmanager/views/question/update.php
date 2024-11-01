<?php

/* @var $this yii\web\View */
/* @var $model \common\modules\testmanager\models\Question */
/* @var $test \common\modules\testmanager\models\TestResult */
/* @var $modelsOption \backend\modules\testmanager\models\Option[] */

$this->title = 'Testni tahrirlash: #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fanlar', 'url' => ['subject/index']];
$this->params['breadcrumbs'][] = ['label' => $test->name, 'url' => ['question/index', 'test_id' => $test->id]];
$this->params['breadcrumbs'][] = ['label' => '#' . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Tahrirlash';
$this->registerCss("
    .radio-area label{
        cursor:pointer;
    }
");
?>

<?= $this->render('_form', [
    'model' => $model,
    'test' => $test,
    'modelsOption' => $modelsOption,
]) ?>

