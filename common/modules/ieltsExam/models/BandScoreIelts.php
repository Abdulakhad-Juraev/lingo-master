<?php

namespace common\modules\ieltsExam\models;

use yii\base\Model;

class BandScoreIelts extends Model
{
    private $bandScores = [
        'listening' => [
            ['raw_min' => 0, 'raw_max' => 1, 'band' => 1.0],
            ['raw_min' => 2, 'raw_max' => 3, 'band' => 1.5],
            ['raw_min' => 4, 'raw_max' => 5, 'band' => 2.0],
            ['raw_min' => 6, 'raw_max' => 7, 'band' => 2.5],
            ['raw_min' => 8, 'raw_max' => 9, 'band' => 3.0],
            ['raw_min' => 10, 'raw_max' => 12, 'band' => 3.5],
            ['raw_min' => 13, 'raw_max' => 15, 'band' => 4.0],
            ['raw_min' => 16, 'raw_max' => 17, 'band' => 4.5],
            ['raw_min' => 18, 'raw_max' => 20, 'band' => 5.0],
            ['raw_min' => 21, 'raw_max' => 22, 'band' => 5.5],
            ['raw_min' => 23, 'raw_max' => 25, 'band' => 6.0],
            ['raw_min' => 26, 'raw_max' => 27, 'band' => 6.5],
            ['raw_min' => 28, 'raw_max' => 29, 'band' => 7.0],
            ['raw_min' => 30, 'raw_max' => 31, 'band' => 7.5],
            ['raw_min' => 32, 'raw_max' => 34, 'band' => 8.0],
            ['raw_min' => 35, 'raw_max' => 36, 'band' => 8.5],
            ['raw_min' => 37, 'raw_max' => 40, 'band' => 9.0],
        ],
        'reading' => [
            ['raw_min' => 0, 'raw_max' => 1, 'band' => 1.0],
            ['raw_min' => 2, 'raw_max' => 3, 'band' => 1.5],
            ['raw_min' => 4, 'raw_max' => 5, 'band' => 2.0],
            ['raw_min' => 6, 'raw_max' => 7, 'band' => 2.5],
            ['raw_min' => 8, 'raw_max' => 9, 'band' => 3.0],
            ['raw_min' => 10, 'raw_max' => 12, 'band' => 3.5],
            ['raw_min' => 13, 'raw_max' => 15, 'band' => 4.0],
            ['raw_min' => 16, 'raw_max' => 17, 'band' => 4.5],
            ['raw_min' => 18, 'raw_max' => 20, 'band' => 5.0],
            ['raw_min' => 21, 'raw_max' => 22, 'band' => 5.5],
            ['raw_min' => 23, 'raw_max' => 25, 'band' => 6.0],
            ['raw_min' => 26, 'raw_max' => 27, 'band' => 6.5],
            ['raw_min' => 28, 'raw_max' => 29, 'band' => 7.0],
            ['raw_min' => 30, 'raw_max' => 31, 'band' => 7.5],
            ['raw_min' => 32, 'raw_max' => 34, 'band' => 8.0],
            ['raw_min' => 35, 'raw_max' => 36, 'band' => 8.5],
            ['raw_min' => 37, 'raw_max' => 40, 'band' => 9.0],
        ],
    ];

    // Function to calculate band score
    public function calculateBandScore($section, $rawScore)
    {
        foreach ($this->bandScores[$section] as $bandScore) {
            if ($rawScore >= $bandScore['raw_min'] && $rawScore <= $bandScore['raw_max']) {
                return $bandScore['band'];
            }
        }
        return null; // If band score is not found
    }

    // Function to get band scores for test
    public function testBandScores($rawScores)
    {
        $results = [];
        foreach ($rawScores as $section => $rawScore) {
            $bandScore = $this->calculateBandScore($section, $rawScore);
            $results[$section] = $bandScore;
        }
        return $results;
    }
}
