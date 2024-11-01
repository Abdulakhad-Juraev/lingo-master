<?php

namespace common\modules\toeflExam\models;

use Yii;

/**
 * This is the model class for table "toefl_user_option".
 *
 * @property int $id
 * @property int|null $question_id
 * @property int|null $result_id
 * @property int|null $option_id
 *
 * @property ToeflOption $toeflOption
 * @property ToeflQuestion $toeflQuestion
 * @property ToeflResult $toeflResult
 */
class ToeflUserOption extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
    * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'toefl_user_option';
    }

    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['question_id', 'result_id', 'option_id'], 'integer'],
            [['option_id'], 'exist', 'skipOnError' => true, 'targetClass' => ToeflOption::className(), 'targetAttribute' => ['option_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => ToeflQuestion::className(), 'targetAttribute' => ['question_id' => 'id']],
            [['result_id'], 'exist', 'skipOnError' => true, 'targetClass' => ToeflResult::className(), 'targetAttribute' => ['result_id' => 'id']],
        ];
    }

    /**
    * {@inheritdoc}
    */
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'yii\behaviors\BlameableBehavior',
        ];
    }

    /**
    * {@inheritdoc}
    */
    public function labels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'result_id' => 'Result ID',
            'option_id' => 'Option ID',
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getToeflOption()
    {
        return $this->hasOne(ToeflOption::className(), ['id' => 'option_id']);
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getToeflQuestion()
    {
        return $this->hasOne(ToeflQuestion::className(), ['id' => 'question_id']);
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getToeflResult()
    {
        return $this->hasOne(ToeflResult::className(), ['id' => 'result_id']);
    }
    
    //</editor-fold>
}
