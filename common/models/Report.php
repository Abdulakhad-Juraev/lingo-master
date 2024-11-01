<?php

namespace common\models;

use yii\base\Model;

class Report extends Model
{
    public $month;
    public $year;

    public function rules()
    {
        return [
            [['month', 'year'], 'required'],
            [['month', 'year'], 'integer'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'month' => 'Oy',
            'year' => 'Yil'
        ];
    }

    /**
     * @return string[]
     */
    public static function months(): array
    {
        return [
            '01' => "Yanvar",
            '02' => "Fevral",
            '03' => "Mart",
            '04' => "Aprel",
            '05' => "May",
            '06' => "Iyun",
            '07' => "Iyul",
            '08' => "Avgust",
            '09' => "Sentyabr",
            '10' => "Oktyabr",
            '11' => "Noyabr",
            '12' => "Dekabr",
        ];
    }

}