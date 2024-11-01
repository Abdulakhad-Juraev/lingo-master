<?php

namespace common\modules\toeflExam\controllers;

use common\modules\toeflExam\models\ToeflQuestion;
use frontend\web\controllers\BaseController;

class ReadingQuestionController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new ToeflQuestion();
    }
}