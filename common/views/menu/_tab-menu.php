<?php


use soft\web\View;
use soft\widget\bs4\TabMenu;

/* @var $this View */
/* @var $model \common\modules\englishExam\models\EnglishExam */

?>


<?= TabMenu::widget([

    'items' => [
        [
            'label' => t('Back'),
            'url' => ['/english-exam/index'],
            'icon' => 'reply,fas',
        ],
        [
            'label' => t('TOEFL Listening'),
            'url' => ['toefl-listening-group/index', 'id' => $model->id],
            'icon' => 'headphones,fas',
            'active' => in_array(
                Yii::$app->controller->route, [
                    'toefl-exam/toefl-listening-group/index',
                    'toefl-exam/toefl-listening-option/index'
                ]
            ),
        ],
        [
            'label' => t('TOEFL Reading'),
            'url' => ['toefl-reading-group/index', 'id' => $model->id],
            'icon' => 'book,fas',
            'active' => Yii::$app->controller->route === 'toefl-exam/toefl-reading-group/index'
        ],
        [
            'label' => t('TOEFL Writing'),
            'url' => ['toefl-question/index', 'id' => $model->id],
            'icon' => 'edit,fas',
            'active' => Yii::$app->controller->route === 'toefl-exam/toefl-question/index',
        ],
    ]

]) ?>
