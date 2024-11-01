<?php

namespace common\modules\ieltsExam\models;

use yii\base\Model;

class IeltsCheckResult extends Model
{
    public $speaking_score;
    public $writing_score;

    public const SCENARIO_SPEAKING = 'speaking';
    public const SCENARIO_WRITING = 'writing';

    public function rules()
    {
        return [
            [['speaking_score', 'writing_score'], 'number'],
            [['speaking_score', 'writing_score'], 'checkValue'],
            [['writing_score'], 'required', 'on' => self::SCENARIO_WRITING],
            [['speaking_score'], 'required', 'on' => self::SCENARIO_SPEAKING],
        ];
    }

    public function checkValue()
    {
        if ($this->scenario === self::SCENARIO_SPEAKING && ($this->speaking_score > 9 || $this->speaking_score < 1)) {
            $this->addError('speaking_score', 'Max 9 bal Min 1');
            return false;
        }
        if ($this->scenario === self::SCENARIO_WRITING &&($this->writing_score > 9 || $this->writing_score < 1)) {
            $this->addError('writing_score', 'Max 9 bal Min 1');
            return false;
        }
        return true;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SPEAKING] = ['speaking_score'];
        $scenarios[self::SCENARIO_WRITING] = ['writing_score'];
        return $scenarios;
    }

    public function attributeLabels()
    {
        return [
            'speaking_score' => 'Speaking score',
            'writing_score' => 'Writing score'
        ];
    }
}