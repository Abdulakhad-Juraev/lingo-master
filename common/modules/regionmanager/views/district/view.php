<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 13.07.2021, 15:18
 */


/* @var $this soft\web\View */

/* @var $model common\modules\regionmanager\models\District */

use common\modules\regionmanager\models\District;
use soft\widget\bs4\DetailView;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tumanlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?= DetailView::widget([
    'model' => $model,
    'panel' => $this->isAjax ? false : [],
    'attributes' => [
        'id',
        [
            'attribute' => 'region_id',
            'value' => function (District $model) {
                return $model->region->name;
            }
        ],
        'name_uz',
        'name_en',
        'name_ru',
    ],
]) ?>