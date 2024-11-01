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
            'url' => ['user/view', 'id' => $model->id],
            'icon' => 'question-circle,far',
        ],
        [
            'label' => t('User Device'),
            'url' => ['user/user-device', 'id' => $model->id],
            'icon' => 'tablet,fa',
        ],
        [
            'label' => t('User Payment'),
            'url' => ['user/user-payment', 'id' => $model->id],
            'icon' => 'list,fas',
        ],
        [
            'label' => t('Test Result'),
            'url' => ['user/test-result', 'id' => $model->id],
            'icon' => 'list,fas',
        ],

    ]

]) ?>
