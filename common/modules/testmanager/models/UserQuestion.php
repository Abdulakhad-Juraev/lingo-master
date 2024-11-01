<?php

namespace common\modules\testmanager\models;

use Yii;

/**
 * This is the model class for table "user_question".
 *
 * @property int $id
 * @property int|null $question_id
 * @property int|null $result_id
 *
 * @property UserOptions[] $userOptions
 * @property Question $question
 * @property TestResult $result
 */
class UserQuestion extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_id', 'result_id'], 'required'],
            [['question_id', 'result_id'], 'integer'],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Question::className(), 'targetAttribute' => ['question_id' => 'id']],
            [['result_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestResult::className(), 'targetAttribute' => ['result_id' => 'id']],
        ];
    }

    public function fields()
    {
        return [
            'question_id',
            'title' => function (UserQuestion $userQuestion) {
                return $userQuestion->question->title;
            },
            'options' => function (UserQuestion $userQuestion) {
                return $userQuestion->userOptions;
            }
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
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOptions()
    {
        return $this->hasMany(UserOptions::className(), ['user_question_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResult()
    {
        return $this->hasOne(TestResult::className(), ['id' => 'result_id']);
    }

    //</editor-fold>
}
