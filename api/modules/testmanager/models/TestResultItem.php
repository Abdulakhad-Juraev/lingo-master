<?php

namespace api\modules\testmanager\models;

use common\modules\testmanager\models\TestResult;
use common\modules\testmanager\models\UserQuestion;

class TestResultItem extends \common\modules\testmanager\models\TestResultItem
{
    public function fields()
    {
        $key = self::generateFieldParam();
        if (isset(self::$fields[$key])) {
            return self::$fields[$key];
        }

        return [
            'question' => function (TestResultItem $model) {
                return $model->question->title;
            },
            'question_id',
            'options' => function (TestResultItem $model) {
                return $model->options;
            },
            'user_answer_id',
            'is_correct',
//            'options' => function (TestResultItem $model) {
//                return $model->userQuestion->userOptions;
//            },
            'original_answer_id' => function (TestResultItem $model) {
                if ($this->testResult->test->show_answer && $this->testResult->status == TestResult::STATUS_FINISHED) {
                    return $this->original_answer_id;
                }
                return '';
            }
        ];
    }

}