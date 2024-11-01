<?php

namespace common\modules\testmanager\models;

use Yii;

/**
 * This is the model class for table "user_options".
 *
 * @property int $id
 * @property int|null $question_id
 * @property int|null $option_id
 *
 * @property Option $option
 * @property UserQuestion $userQuestion
 */
class UserOptions extends \soft\db\ActiveRecord
{
    //<editor-fold desc="Parent" defaultstate="collapsed">

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_id', 'option_id','result_id'], 'integer'],
            [['option_id'], 'exist', 'skipOnError' => true, 'targetClass' => Option::className(), 'targetAttribute' => ['option_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserQuestion::className(), 'targetAttribute' => ['question_id' => 'id']],
            [['result_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestResult::className(), 'targetAttribute' => ['result_id' => 'id']],
        ];
    }

    public function fields()
    {
        return [
            'option_id',
            'question_id',
            'text' => function (UserOptions $userOptions) {
                return $userOptions->option->text;
            }
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
            'question_id' => 'User Question ID',
            'option_id' => 'Option ID',
        ];
    }
    //</editor-fold>

    //<editor-fold desc="Relations" defaultstate="collapsed">

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(Option::className(), ['id' => 'option_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(UserQuestion::className(), ['id' => 'question_id']);
    }

    //</editor-fold>
}
