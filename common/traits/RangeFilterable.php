<?php

namespace common\traits;

use kartik\daterange\DateRangePicker;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

trait RangeFilterable
{
    public ?string $range = null;
    public ?string $start_date = null;
    public ?string $finish_date = null;

    /**
     * @return string[]
     */
    public function getRangeValidatorRule(): array
    {
        return [
            [['start_date', 'finish_date'], 'safe'],
            ['range', 'validateRange'],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * @param $validator
     */
    public function validateRange($attribute, $params, $validator): void
    {
        if (!(($this->start_date = strtotime($this->start_date)) && ($this->finish_date = strtotime($this->finish_date . " +1day")) && $this->start_date < $this->finish_date)) {
            $this->addError($attribute, "To'g'ri sana kiritilmagan.");
        }
    }

    /**
     * @param ActiveQuery $query
     * @param string $table
     * @return void
     */
    public function addRangeFilter(ActiveQuery &$query, string $table)
    {
        $query
            ->andFilterWhere(['>=', "{$table}.created_at", $this->start_date])
            ->andFilterWhere(['<=', "{$table}.created_at", $this->finish_date]);
    }

    /**
     * @param ActiveRecord $searchModel
     * @return string
     * @throws \Throwable
     */
    public static function getFilter(ActiveRecord $searchModel): string
    {
        return DateRangePicker::widget([
            'model' => $searchModel,
            'attribute' => 'range',
            'startAttribute' => 'start_date',
            'endAttribute' => 'finish_date',
            'presetDropdown' => true,
            'convertFormat' => true,
            'pluginOptions' => [
                'locale' => [
                    'format' => 'd.m.Y'
                ],
            ],
        ]);
    }
}