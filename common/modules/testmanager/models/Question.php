<?php

namespace common\modules\testmanager\models;

use common\modules\testmanager\models\traits\QuestionDynamicFormTrait;
use common\modules\testmanager\models\traits\ToeflQuestionDynamicFormTrait;
use soft\db\ActiveRecord;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "question".
 *
 * @property int $id
 * @property string $title
 * @property int|null $test_id
 * @property int|null $status
 * @property int|null $user_id
 * @property int|null $updated_by
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Option[] $options
 * @property Test $subject
 */
class Question extends ActiveRecord
{

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;
    public const STATUS_DELETE = 2;
    use QuestionDynamicFormTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'test_id'], 'required'],
            [['title'], 'string'],
            [['test_id', 'status', 'user_id', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['test_id'], 'exist', 'skipOnError' => true, 'targetClass' => Test::className(), 'targetAttribute' => ['test_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Savol matni',
            'test_id' => 'Test',
            'subject.name' => 'Test',
            'status' => Yii::t('app', 'Status'),
            'user_id' => Yii::t('app', 'User ID'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'user_id',
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(Option::className(), ['question_id' => 'id']);
    }

    public function getCorrectAnswer(): mixed
    {
        return $this->getOptions()->andWhere(['is_answer' => 1])->one()->id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRandomOptions()
    {
        return $this->getOptions()->orderBy(new Expression('rand()'));
    }

    /**
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(Test::className(), ['id' => 'test_id']);
    }

//    public function getUserOptions($result_id): \soft\db\ActiveQuery
//    {
//        return $this->hasMany(UserOptions::className(), ['question_id' => 'id'])->andWhere(['result_id' => $result_id]);
//    }
    public function getUserOptions(): \soft\db\ActiveQuery
    {
        return $this->hasMany(UserOptions::class, ['question_id' => 'id']);
    }
}
