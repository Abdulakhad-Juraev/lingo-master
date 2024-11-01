<?php

namespace common\traits;
/**
 *
 * User modeli uchun tariflar bilan bog'liq methodlar
 * @see \common\models\User
 * @property IeltsResult[] $activeIeltsTest
 * @property IeltsResult[] $activeIeltsTestListening
 * @property IeltsResult[] $activeIeltsTestReading
 * @property IeltsResult[] $activeIeltsTestWriting
 * @property IeltsResult $activeUserTariff
 */

use common\modules\ieltsExam\models\IeltsResult;
use Yii;


trait IeltsResultTrait
{
    private $_hasActiveIeltsResult;

    public function getActiveIeltsTest()
    {
        return $this->hasOne(IeltsResult::class, ['user_id' => 'id'])
            ->andWhere(['status' => IeltsResult::STATUS_ACTIVE])
            ->andWhere(['!=', 'step', IeltsResult::STEP_FINISHED]);
    }
    public function getActiveIeltsTestListening()
    {
        return $this->getActiveIeltsTest()->andWhere(['step' => IeltsResult::STEP_LISTENING]);
    }

    public function getActiveIeltsTestReading()
    {
        return $this->getActiveIeltsTest()->andWhere(['step' => IeltsResult::STEP_READING]);
    }

    public function getActiveIeltsTestWriting()
    {
        return $this->getActiveIeltsTest()->andWhere(['step' => IeltsResult::STEP_READING]);
    }

    public function getHasActiveIeltsResult()
    {
        if ($this->_hasActiveIeltsResult === null) {
            $this->_hasActiveIeltsResult = $this->getActiveUserTariff()->exists();
        }
        return $this->_hasActiveIeltsResult;
    }

    public function getLastIeltsResult()
    {
        return $this->hasOne(IeltsResult::class, ['user_id' => 'id'])->orderBy('id DESC');
    }



}