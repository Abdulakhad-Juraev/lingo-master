<?php

namespace common\modules\testmanager\models;

use soft\db\ActiveRecord;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "test_result_item".
 *
 * @property int $id
 * @property int|null $test_result_id
 * @property int|null $question_id
 * @property int|null $user_answer_id
 * @property int|null $original_answer_id
 * @property int|null $is_correct
 *
 * @property Option $originalAnswer
 * @property Question $question
 * @property UserQuestion $userQuestion
 * @property TestResult $testResult
 * @property-read string $userAnswerText
 * @property-read string $answerIcon
 * @property Option $userAnswer
 */
class TestResultItem extends ActiveRecord
{

    public const IS_CORRECT_TRUE = 1;
    public const IS_CORRECT_FALSE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_result_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['test_result_id', 'question_id', 'user_answer_id', 'original_answer_id', 'is_correct'], 'integer'],
            ['is_correct', 'default', 'value' => 0],
            [['original_answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Option::className(), 'targetAttribute' => ['original_answer_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'id']],
            [['test_result_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestResult::className(), 'targetAttribute' => ['test_result_id' => 'id']],
            [['user_answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Option::className(), 'targetAttribute' => ['user_answer_id' => 'id']],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'question.title' => 'Savol matni',
            'userAnswerText' => 'Foydalanuvchi javobi',
            'answerIcon' => "To'g'ri/Xato"
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOriginalAnswer()
    {
        return $this->hasOne(Option::className(), ['id' => 'original_answer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    public function getOptions()
    {
        return UserOptions::find()
            ->select(['user_options.option_id', 'option.text']) // Select the required fields
            ->leftJoin('option', 'option.id = user_options.option_id') // Left join with the 'option' table
            ->andWhere(['user_options.result_id' => $this->test_result_id]) // Filter by 'result_id'
            ->andWhere(['user_options.question_id' => $this->question_id]) // Filter by 'question_id'
            ->asArray()
            ->all();
    }



    public function getTestResult()
    {
        return $this->hasOne(TestResult::className(), ['id' => 'test_result_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAnswer()
    {
        return $this->hasOne(Option::className(), ['id' => 'user_answer_id']);
    }

    public function getUserAnswerText()
    {
        if ($this->userAnswer) {
            return $this->userAnswer->text;
        }
        return Html::tag('i', 'Javob belgilanmadi', ['class' => 'text-danger']);
    }

    public function getAnswerIcon()
    {
        if ($this->is_correct) {
            return "<span class='text-success'><i class='fa fa-check'></i></span>";
        } else {
            return "<span class='text-danger'><i class='fa fa-times'></i></span>";
        }
    }
}
