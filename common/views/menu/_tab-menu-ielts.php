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
            'label' => t('IELTS Listening'),
            'url' => ['ielts-question-group-listening/index', 'id' => $model->id],
            'icon' => 'headphones,fas',
            'active' => in_array(
                Yii::$app->controller->route, [
                    'ielts-exam/ielts-question-group-listening/index',
                    'english-exam/ielts-listening-option/index'
                ]
            ),
        ],
        [
            'label' => t('IELTS Reading'),
            'url' => ['ielts-question-group-reading/index', 'id' => $model->id],
            'icon' => 'book,fas',
            'active' => in_array(
                Yii::$app->controller->route, [
                    'ielts-exam/ielts-question-group-reading/index',
                    'english-exam/ielts-listening-option/index'
                ]
            ),
        ],
        [
            'label' => t('IELTS Writing'),
            'url' => ['ielts-questions-writing/index', 'id' => $model->id],
            'icon' => 'edit,fas',
            'active' => in_array(
                Yii::$app->controller->route, [
                    'ielts-exam/ielts-questions-writing/index',
                    'english-exam/ielts-listening-option/index'
                ]
            ),
        ],
        [
            'label' => t('IELTS Speaking'),
            'url' => ['ielts-questions-speaking/index', 'id' => $model->id],
            'icon' => 'microphone,fas',
            'active' => in_array(
                Yii::$app->controller->route, [
                    'ielts-exam/ielts-questions-speaking/index',
                    'english-exam/ielts-listening-option/index'
                ]
            ),
        ],
    ]

]) ?>
