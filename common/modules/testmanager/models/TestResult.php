<?php

namespace common\modules\testmanager\models;

use common\modules\testmanager\models\TestResultItem;
use common\models\User;
use soft\db\ActiveRecord;
use soft\helpers\ArrayHelper;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the model class for table "test_result".
 *
 * @property int $id
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $course_id
 *
 * @property int $user_id [int(11)]
 * @property int $duration [smallint(6)]
 * @property int $test_id [int(11)]
 * @property int $score [int(11)]
 * @property int $started_at [int(11)]
 * @property int $tests_count [smallint(6)]
 * @property int $correct_answers [smallint(6)]
 * @property int $expire_at [int(11)]
 * @property int $price [int(11)]
 * @property int $finished_at [int(11)]
 *
 *
 * @property-read Test $subject
 * @property TestResultItem[] $testResultItems
 *
 * @property-read bool $isFinished
 * @property-read bool $isExpired
 * @property-read int $leftTime
 * @property-read Question[] $questions
 * @property-read float|int $percent
 * @property-read mixed $formattedPercent
 * @property-read string $formattedFinishedTime
 * @property-read string $formattedStartedTime
 * @property-read \common\models\User $user
 * @property-read Test $test
 * @property-read bool $isStarted
 */
class TestResult extends ActiveRecord
{

    public const STATUS_ACTIVE = 1;
    public const STATUS_FINISHED = 0;

    const ALLOWED_EXTRA_TIME = 60;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test_result';
    }

    public static function getStatues(): array
    {
        return [
            self::STATUS_ACTIVE => t('Active'),
            self::STATUS_FINISHED => 'Yakunlangan'
        ];
    }

    public function statusName()
    {
        return ArrayHelper::getArrayValue($this->getStatues(), $this->status, $this->status);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'tests_count', 'test_id'], 'required'],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['status', 'user_id', 'test_id', 'started_at', 'tests_count', 'correct_answers', 'expire_at', 'price', 'finished_at', 'score'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'firstname' => "Ism",
            'lastname' => "Familiya",
            'phone' => 'Tel. raqam',
            'status' => t('Status'),
            'created_at' => t('Created At'),
            'price' => t('Cost'),
            'tests_count' => t('Tests Count'),
            'started_at' => t('Start time'),
            'formattedStartedTime' => t('Start time'),
            'finished_at' => t('End time'),
            'formattedFinishedTime' => t('End time'),
            'correct_answers' => t('Correct answers'),
            'formattedPercent' => t('Percentage'),
            'duration' => t('Duration of time')
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTest(): ActiveQuery
    {
        return $this->hasOne(Test::class, ['id' => 'test_id'])->with(['course', 'direction', 'subject']);
    }


    public function getUser(): \soft\db\ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTestResultItems()
    {
        return $this->hasMany(TestResultItem::className(), ['test_result_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getQuestions(): ActiveQuery
    {
        return $this->hasMany(Question::class, ['id' => 'question_id'])
            ->via('testResultItems')
            ->select(['question.id', 'question.title'])
            ->innerJoin('test_result_item', 'test_result_item.question_id = question.id AND test_result_item.test_result_id = :result_id', [':result_id' => $this->id])
            ->with(['userOptions' => function ($query) {
                $query
                    ->andWhere(['user_options.result_id' => $this->id]) // Filter by "result_id"
                    ->leftJoin('option', 'option.id = user_options.option_id') // Join with "option" table to get "option.text"
                    ->select(['user_options.id', 'user_options.question_id', 'user_options.option_id', 'option.text']); // Select required columns
            }])
            ->orderBy(['test_result_item.id' => SORT_ASC]) // Order by the id of the test_result_item, which typically implies the order of insertion
            ->asArray();
    }


    public function getUserOptions(): ActiveQuery
    {
        return $this->hasMany(UserOptions::class, ['question_id' => 'id'])
            ->via('questions');
    }


    /**
     * @return bool
     */
    public function getIsExpired()
    {
        return $this->leftTime <= 0;
    }

    /**
     * @return bool
     */
    public function getIsStarted()
    {
        return $this->started_at != null;
    }

    /**
     * @return bool
     */
    public function getIsFinished()
    {
        return $this->finished_at != null;
    }

    /**
     * Testning tugashiga qolgan vaqt
     * @return int
     */
    public function getLeftTime()
    {
        return $this->expire_at - time();
    }

    /**
     * @throws \yii\db\Exception
     */
    public function prepare()
    {
        $items = $this->testResultItems;
        if (!empty($items)) {
            return true; // If items already exist, no need to proceed
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $questions = [];

            if ($this->test->current_test_count != 0) {
                $currentQuestions = Question::find()
                    ->andWhere(['test_id' => $this->test_id])
                    ->andWhere(['status' => 1])
                    ->orderBy(new Expression('rand()'))
                    ->limit($this->test->current_test_count)
                    ->all();

                if (empty($currentQuestions)) {
                    throw new \Exception('No current questions found');
                }

                $questions = array_merge($questions, $currentQuestions);
            }

            if ($this->test->old_test_count != 0) {
                $oldQuestions = Question::find()
                    ->andWhere(['!=', 'test_id', $this->test_id])
                    ->andWhere(['status' => 1])
                    ->orderBy(new Expression('rand()'))
                    ->limit($this->test->old_test_count)
                    ->all();

                if (empty($oldQuestions)) {
                    throw new \Exception('No old questions found');
                }

                $questions = array_merge($questions, $oldQuestions);
            }

            foreach ($questions as $question) {
                $testResultItem = new TestResultItem();
                $testResultItem->test_result_id = $this->id;
                $testResultItem->question_id = $question->id;

                if (!$testResultItem->save()) {
                    throw new \Exception('Failed to save test result item');
                }
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    public function start()
    {
        $this->started_at = time();
        $this->expire_at = $this->started_at + $this->duration * 60;
        $this->save(false);
    }

    /**
     * @param $userAnswers array
     */
    public function saveUserAnswers($userAnswers)
    {
        $correctAnswersCount = 0;

        /** @var TestResultItem[] $items */
        $items = $this->getTestResultItems()
            ->with('question.options')
            ->all();


        foreach ($items as $item) {

            $question = $item->question;
            $options = $question->options;
            $correctAnswer = null;
            foreach ($options as $option) {
                if ($option->is_answer) {
                    $correctAnswer = $option;
                    break;
                }
            }

            $originalAnswerId = $correctAnswer->id ?? null;
            $item->original_answer_id = $originalAnswerId;

            if (isset($userAnswers[$question->id])) {

                $userAnswerId = intval($userAnswers[$question->id]);
                $isCorrect = $originalAnswerId == $userAnswerId;
                $item->user_answer_id = $userAnswerId;
                $item->is_correct = $isCorrect ? 1 : 0;
                if ($isCorrect) {
                    $correctAnswersCount++;
                }
            }

            $item->save();

        }

        $this->correct_answers = $correctAnswersCount;
        $this->finished_at = time();
        $this->save();

    }

    /**
     * @return float|int
     */
    public function getPercent()
    {
        $tests_count = $this->tests_count;
        $correct_answers = $this->correct_answers;
        if (empty($tests_count) || empty($correct_answers)) {
            return 0;
        }

        return $correct_answers / $tests_count;
    }

    /**
     * @return string
     */
    public function getFormattedPercent()
    {
        return Yii::$app->formatter->asPercent($this->percent);
    }


    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getFormattedFinishedTime()
    {
        return $this->finished_at ? Yii::$app->formatter->asDatetime($this->finished_at) : '';
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getFormattedStartedTime()
    {
        return $this->started_at ? Yii::$app->formatter->asDatetime($this->started_at) : '';
    }

    public function getPriceText()
    {
        if ($this->price == 0) {
            return 'Bepul';
        }

        return Yii::$app->formatter->asInteger($this->price) . " so'm";
    }

    public function correctAnswerCount()
    {
        return $this->getTestResultItems()->andWhere(['is_correct' => TestResultItem::IS_CORRECT_TRUE])->count();
    }
}
