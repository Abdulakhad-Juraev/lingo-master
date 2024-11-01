<?php

namespace common\traits;

/**
 *
 * User modeli uchun tariflar bilan bog'liq methodlar
 * @see \common\models\User
 * @property ToeflResult[] $activeToeflTest
 * @property ToeflResult[] $activeToeflTestListening
 * @property ToeflResult[] $activeToeflTestReading
 * @property ToeflResult[] $activeToeflTestWriting
 * @property ToeflResult $activeUserTariff
 */

use common\modules\toeflExam\models\ToeflResult;


trait ToeflResultTrait
{
    private $_hasActiveToeflResult;

    public function getActiveToeflTest()
    {
        return $this->hasOne(ToeflResult::class, ['user_id' => 'id'])
            ->andWhere(['status' => ToeflResult::STATUS_ACTIVE])
            ->andWhere(['!=', 'step', ToeflResult::STEP_FINISHED]);
    }

    public function getActiveToeflTestListening()
    {
        return $this->getActiveToeflTest()->andWhere(['step' => ToeflResult::STEP_LISTENING]);
    }

    public function getActiveToeflTestReading()
    {
        return $this->getActiveToeflTest()->andWhere(['step' => ToeflResult::STEP_READING]);
    }

    public function getActiveToeflTestWriting()
    {
        return $this->getActiveToeflTest()->andWhere(['step' => ToeflResult::STEP_READING]);
    }

    public function getHasActiveToeflResult()
    {
        if ($this->_hasActiveToeflResult === null) {
            $this->_hasActiveToeflResult = $this->getActiveUserTariff()->exists();
        }
        return $this->_hasActiveToeflResult;
    }

    public function getLastToeflResult()
    {
        return $this->hasOne(ToeflResult::class, ['user_id' => 'id'])->orderBy('id DESC');
    }
}