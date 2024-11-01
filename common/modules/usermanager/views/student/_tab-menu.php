<?php


use common\modules\book\models\Book;
use common\modules\usermanager\models\Student;
use common\modules\video\models\Video;
use soft\web\View;
use soft\widget\bs4\TabMenu;

/* @var $this View */
/* @var $model Student */

?>


<?= TabMenu::widget([

    'items' => [

        [
            'label' => t('Read more'),
            'url' => ['student/view', 'id' => $model->id],
            'icon' => 'question-circle,far',
        ],
        [
            'label' => t('User Device'),
            'url' => ['student/user-device', 'id' => $model->id],
            'icon' => 'tablet,fa',
        ],
        [
            'label' => t('User payments'),
            'url' => ['student/user-payment', 'id' => $model->id],
            'icon' => 'list,fas',
        ],
        [
            'label' => t('Test Result'),
            'url' => ['student/test-result', 'id' => $model->id],
            'icon' => 'list,fas',
        ],

    ]

]) ?>
