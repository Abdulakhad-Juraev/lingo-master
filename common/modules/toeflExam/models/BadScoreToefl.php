<?php

namespace common\modules\toeflExam\models;

use yii\base\Model;

class BadScoreToefl extends Model
{
    // Define scaled scores as a class property
    private $scaledScores = [
        'listening' => [
            ['raw_min' => 0, 'raw_max' => 5, 'scaled1' => 31, 'scaled2' => 31],
            ['raw_min' => 6, 'raw_max' => 8, 'scaled1' => 31, 'scaled2' => 32],
            ['raw_min' => 9, 'raw_max' => 11, 'scaled1' => 33, 'scaled2' => 35],
            ['raw_min' => 12, 'raw_max' => 14, 'scaled1' => 40, 'scaled2' => 40],
            ['raw_min' => 15, 'raw_max' => 17, 'scaled1' => 41, 'scaled2' => 42],
            ['raw_min' => 18, 'raw_max' => 20, 'scaled1' => 43, 'scaled2' => 44],
            ['raw_min' => 21, 'raw_max' => 23, 'scaled1' => 47, 'scaled2' => 48],
            ['raw_min' => 24, 'raw_max' => 26, 'scaled1' => 48, 'scaled2' => 49],
            ['raw_min' => 27, 'raw_max' => 29, 'scaled1' => 50, 'scaled2' => 51],
            ['raw_min' => 30, 'raw_max' => 32, 'scaled1' => 50, 'scaled2' => 51],
            ['raw_min' => 33, 'raw_max' => 35, 'scaled1' => 51, 'scaled2' => 53],
            ['raw_min' => 36, 'raw_max' => 38, 'scaled1' => 53, 'scaled2' => 55],
            ['raw_min' => 39, 'raw_max' => 41, 'scaled1' => 55, 'scaled2' => 57],
            ['raw_min' => 42, 'raw_max' => 44, 'scaled1' => 58, 'scaled2' => 60],
            ['raw_min' => 45, 'raw_max' => 47, 'scaled1' => 62, 'scaled2' => 63],
            ['raw_min' => 48, 'raw_max' => PHP_INT_MAX, 'scaled1' => 64, 'scaled2' => 68],
        ],
        'writing' => [
            ['raw_min' => 0, 'raw_max' => 5, 'scaled1' => 31, 'scaled2' => 31],
            ['raw_min' => 6, 'raw_max' => 8, 'scaled1' => 31, 'scaled2' => 31],
            ['raw_min' => 9, 'raw_max' => 11, 'scaled1' => 35, 'scaled2' => 38],
            ['raw_min' => 12, 'raw_max' => 14, 'scaled1' => 39, 'scaled2' => 42],
            ['raw_min' => 15, 'raw_max' => 17, 'scaled1' => 42, 'scaled2' => 44],
            ['raw_min' => 18, 'raw_max' => 20, 'scaled1' => 45, 'scaled2' => 47],
            ['raw_min' => 21, 'raw_max' => 23, 'scaled1' => 48, 'scaled2' => 49],
            ['raw_min' => 24, 'raw_max' => 26, 'scaled1' => 50, 'scaled2' => 52],
            ['raw_min' => 27, 'raw_max' => 29, 'scaled1' => 53, 'scaled2' => 55],
            ['raw_min' => 30, 'raw_max' => 32, 'scaled1' => 56, 'scaled2' => 58],
            ['raw_min' => 33, 'raw_max' => 35, 'scaled1' => 59, 'scaled2' => 61],
            ['raw_min' => 36, 'raw_max' => 40, 'scaled1' => 63, 'scaled2' => 68],
        ],
        'reading' => [
            ['raw_min' => 0, 'raw_max' => 5, 'scaled1' => 31, 'scaled2' => 31],
            ['raw_min' => 6, 'raw_max' => 8, 'scaled1' => 31, 'scaled2' => 31],
            ['raw_min' => 9, 'raw_max' => 11, 'scaled1' => 31, 'scaled2' => 31],
            ['raw_min' => 12, 'raw_max' => 14, 'scaled1' => 32, 'scaled2' => 37],
            ['raw_min' => 15, 'raw_max' => 17, 'scaled1' => 39, 'scaled2' => 42],
            ['raw_min' => 18, 'raw_max' => 20, 'scaled1' => 43, 'scaled2' => 45],
            ['raw_min' => 21, 'raw_max' => 23, 'scaled1' => 45, 'scaled2' => 47],
            ['raw_min' => 24, 'raw_max' => 26, 'scaled1' => 48, 'scaled2' => 49],
            ['raw_min' => 27, 'raw_max' => 29, 'scaled1' => 49, 'scaled2' => 51],
            ['raw_min' => 30, 'raw_max' => 32, 'scaled1' => 51, 'scaled2' => 52],
            ['raw_min' => 33, 'raw_max' => 35, 'scaled1' => 53, 'scaled2' => 54],
            ['raw_min' => 36, 'raw_max' => 38, 'scaled1' => 54, 'scaled2' => 56],
            ['raw_min' => 39, 'raw_max' => 41, 'scaled1' => 56, 'scaled2' => 58],
            ['raw_min' => 42, 'raw_max' => 44, 'scaled1' => 58, 'scaled2' => 60],
            ['raw_min' => 45, 'raw_max' => 47, 'scaled1' => 61, 'scaled2' => 63],
            ['raw_min' => 48, 'raw_max' => PHP_INT_MAX, 'scaled1' => 65, 'scaled2' => 67],
        ],
    ];

    // Skalali ballarni hisoblash funktsiyasi
    public function calculateAverageScaledScore($section, $rawScore)
    {
        foreach ($this->scaledScores[$section] as $scaledScore) {
            if ($rawScore >= $scaledScore['raw_min'] && $rawScore <= $scaledScore['raw_max']) {
                // Ikki skalali ballarni qo'shib o'rtacha hisoblash
                return ($scaledScore['scaled2']);
            }
        }
        return null; // Agar skalali ball topilmagan bo'lsa
    }

    // Test uchun skaillangan ballarni olish
    public function testScaledScores($rawScores)
    {
        $results = [];
        foreach ($rawScores as $section => $rawScore) {
            $scaledScore = $this->calculateAverageScaledScore($section, $rawScore);
            $results[] = $scaledScore;
        }
        return $results;
    }
}

//
//// Example usage:
//$model = new BadScoreToefl();
//$rawScores = [
//    'listening' => 40,
//    'writing' => 35,
//    'reading' => 45,
//];
//$results = $model->testScaledScores($rawScores);
//foreach ($results as $result) {
//    echo "$result\n";
//}
?>