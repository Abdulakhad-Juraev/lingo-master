<?php

namespace api\modules\ieltsExam\models;

class EnglishExam extends \common\modules\toeflExam\models\EnglishExam
{
    public function fields()
    {
        $key = self::generateFieldParam();
        if (isset(self::$fields[$key])) {
            return self::$fields[$key];
        }
        return [
            'id',
            'title',
            'img' => function (EnglishExam $model) {
                return $model->getFileUrl();
            },
            'price',
            'number_attempts',
            'reading_duration',
            'listening_duration',
            'writing_duration',
            'speaking_duration',
            'canUse',
            'result' => function (EnglishExam $model) {
                if (is_guest()) {
                    return 0;
                }
                /** @var IeltsResult $lastIelts */
                $lastIelts = user()->lastIeltsResult;
                return $lastIelts ? $lastIelts->getIeltsBandScore() : 0;

            }
        ];
    }

    public function getCanUse()
    {
        if (is_guest()) {
            return false;
        }
        if (user()->hasActiveTariff) {
            return true;
        }
        return false;
    }
}