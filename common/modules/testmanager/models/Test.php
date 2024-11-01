<?php

namespace common\modules\testmanager\models;

use common\modules\university\models\Course;
use common\modules\university\models\Direction;
use common\modules\university\models\Language;
use common\modules\university\models\Semester;
use soft\behaviors\TimestampConvertorBehavior;
use soft\db\ActiveQuery;
use soft\db\ActiveRecord;
use soft\helpers\ArrayHelper;
use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "subject".
 *
 * @property int $id
 * @property string $name
 * @property int|null $is_free
 * @property int|null $price
 * @property int|null $started_at
 * @property int|null $finished_at
 * @property int|null $test_type
 * @property int|null $maximum_score
 * @property int|null $old_test_count
 * @property int|null $current_test_count
 * @property int|null $subject_id
 * @property int|null $educational_type
 * @property int|null $educational_form
 * @property int|null $direction_id
 * @property int|null $course_id
 * @property int|null $number_tries
 * @property int|null $semester_id
 * @property int|null $control_type_id
 * @property int|null $language_id
 * @property int|null $status
 * @property int $duration [int(11)]  Vaqt (minutlarda)
 * @property int $tests_count [smallint(6)]  Testlar soni
 *
 * @property-read Question[] $questions
 * @property-read Subject[] $subject
 * @property-read int $activeQuestionsCount
 * @property-read string $formattedPrice
 * @property-read string $nameAndPrice
 * @property bool $show_answer [tinyint(1)]
 *
 */
class Test extends ActiveRecord
{

    public const CONTROL_SIMPLE_CONTROL = 1;
    public const CONTROL_TYPE_INTERMEDIATE_CONTROL = 2;
    public const CONTROL_TYPE_FINAL_CONTROL = 3;

    public const EDUCATIONAL_TYPE_BACHELOR = 1;

    public const EDUCATIONAL_TYPE_MASTER = 2;

    public const EDUCATIONAL_FROM_DAY_TIME = 1;

    public const EDUCATIONAL_TYPE_EVENING = 2;
    public const EDUCATIONAL_TYPE_OUTSIDE = 3;

    public const TEST_TYPE_OPEN = 1;
    public const TEST_TYPE_CLOSE = 2;


    public static function testTypes(): array
    {
        return [
            self::TEST_TYPE_OPEN => Yii::t('app', 'TEST_TYPE_OPEN'),
            self::TEST_TYPE_CLOSE => Yii::t('app', 'TEST_TYPE_CLOSE')
        ];
    }

    public static function educationalTypes(): array
    {
        return [
            self::EDUCATIONAL_TYPE_BACHELOR => Yii::t('app', 'EDUCATIONAL_TYPE_BACHELOR'),
            self::EDUCATIONAL_TYPE_MASTER => Yii::t('app', 'EDUCATIONAL_TYPE_MASTER'),
        ];
    }

    public function educationalTypeName()
    {
        return ArrayHelper::getArrayValue(self::educationalTypes(), $this->educational_type, $this->educational_type);
    }

    public static function educationalFrom(): array
    {
        return [
            self::EDUCATIONAL_FROM_DAY_TIME => Yii::t('app', 'EDUCATIONAL_FROM_DAY_TIME'),
            self::EDUCATIONAL_TYPE_EVENING => Yii::t('app', 'EDUCATIONAL_TYPE_EVENING'),
            self::EDUCATIONAL_TYPE_OUTSIDE => Yii::t('app', 'EDUCATIONAL_TYPE_OUTSIDE'),
        ];
    }

    public function educationalFromName()
    {
        return ArrayHelper::getArrayValue(self::educationalFrom(), $this->educational_form, $this->educational_form);
    }

    public function getTestTypeName()
    {
        return ArrayHelper::getArrayValue(self::testTypes(), $this->test_type, $this->test_type);
    }

    public static function controlTypes(): array
    {
        return [
            self::CONTROL_TYPE_INTERMEDIATE_CONTROL => Yii::t('app', 'CONTROL_TYPE_INTERMEDIATE_CONTROL'),
            self::CONTROL_TYPE_FINAL_CONTROL => Yii::t('app', 'CONTROL_TYPE_FINAL_CONTROL')
        ];
    }

    public function getControlTypeName(): mixed
    {
        return ArrayHelper::getArrayValue(self::testTypes(), $this->control_type_id, $this->control_type_id);

    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'duration', 'tests_count', 'test_type', 'subject_id', 'started_at', 'number_tries', 'maximum_score',], 'required'],
            [['is_free', 'price', 'status', 'show_answer', 'test_type', 'old_test_count', 'maximum_score', 'current_test_count', 'subject_id', 'direction_id', 'course_id', 'semester_id', 'control_type_id', 'language_id', 'number_tries', 'educational_type', 'educational_form'], 'integer'],
            [['duration', 'tests_count'], 'integer', 'min' => 10],
            [['name'], 'string', 'max' => 100],
            [['old_test_count', 'current_test_count', 'number_tries'], 'default', 'value' => 0],
            [['old_test_count', 'current_test_count'], 'checkValue'],
            ['price', 'default', 'value' => 0],
            [['started_at', 'finished_at'], 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampConvertorBehavior::class,
                'attribute' => ['finished_at', 'started_at'],
            ],
        ];
    }

    public function checkValue(): bool
    {
        $this->old_test_count = $this->old_test_count ?? 0;
        $this->current_test_count = $this->current_test_count ?? 0;
        if (($this->old_test_count != 0 || $this->current_test_count != 0) && ($this->old_test_count + $this->current_test_count) != $this->tests_count) {
            $this->addError('current_test_count', Yii::t('app', 'current_test_count_error'));
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'is_free' => Yii::t('app', 'Free'),
            'price' => Yii::t('app', 'Cost'),
            'status' => Yii::t('app', 'Status'),
            'statusBadge' => Yii::t('app', 'Status'),
            'duration' => Yii::t('app', 'Duration of time'),
            'tests_count' => Yii::t('app', 'Tests Count'),
            'show_answer' => Yii::t('app', 'Show answers'),
            'started_at' => Yii::t('app', 'Start time'),
            'finished_at' => Yii::t('app', 'End time'),
            'test_type' => Yii::t('app', 'Test Type'),
            'old_test_count' => Yii::t('app', 'Old Test Count'),
            'current_test_count' => Yii::t('app', 'Number to be taken from the new test'),
            'subject_id' => Yii::t('app', 'Subjects'),
            'direction_id' => Yii::t('app', 'Direction'),
            'course_id' => Yii::t('app', 'Course'),
            'semester_id' => Yii::t('app', 'Semester'),
            'control_type_id' => Yii::t('app', 'Type of control'),
            'language_id' => Yii::t('app', 'Test language'),
            'number_tries' => Yii::t('app', 'Number of attempts'),
            'maximum_score' => Yii::t('app', 'Maximum score'),
            'educational_type' => Yii::t('app', 'Educational Type'),
            'educational_form' => Yii::t('app', 'Educational Form'),
        ];
    }

    public function getQuestions(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Question::class, ['test_id' => 'id']);
    }

    public function getResults(): ActiveQuery
    {
        return $this->hasMany(TestResult::class, ['test_id' => 'id'])->andWhere(['status' => TestResult::STATUS_FINISHED])->orderBy('score DESC');
    }

    public function getSubject(): ActiveQuery
    {
        return $this->hasOne(Subject::class, ['id' => 'subject_id']);
    }

    public function getSemester(): ActiveQuery
    {
        return $this->hasOne(Semester::class, ['id' => 'semester_id']);
    }

    public function getDirection(): ActiveQuery
    {
        return $this->hasOne(Direction::class, ['id' => 'direction_id']);
    }

    public function getCourse(): ActiveQuery
    {
        return $this->hasOne(Course::class, ['id' => 'course_id']);
    }

    public function getLanguage(): ActiveQuery
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }

    /**
     * @return int
     */
    public function getActiveQuestionsCount(): int
    {
        return (int)$this->getQuestions()->andWhere(['status' => 1])->count();
    }

    /**
     * @param int $limit
     */
    public function randomTests($limit = 10): array
    {
        return $this->getQuestions()
            ->limit($limit)
            ->asArray()
            ->with(['options' => function ($query) {
                /** @var \yii\db\ActiveQuery $query */
                return $query->orderBy(new Expression('rand()'));

            }])
            ->orderBy(new Expression('rand()'))
            ->all();
    }

    public function createTestResult()
    {
        $testResult = new TestResult();
        $testResult->test_id = $this->id;
        $testResult->user_id = Yii::$app->user->getId();
        $testResult->duration = $this->duration;
        $testResult->price = $this->is_free ? 0 : $this->price;
        $testResult->tests_count = $this->tests_count;

        if ($testResult->save()) {
            return $testResult->id;
        } else {
            return false;
        }
    }

    public function prepareQuestions(): array
    {
        $old_questions = [];
        $result = [];
        // Eski testlar uchun savollarni olish (agar old_test_count mavjud bo'lsa)
        if ($this->old_test_count > 0) {
            $old_questions = Question::find()
                ->joinWith('test') // Test jadvalini join qilish
                ->where(['test.subject_id' => $this->subject_id]) // Shu fan bo'yicha savollarni olish
                ->andWhere(['!=', 'question.test_id', $this->id]) // Joriy testni chiqarib tashlash
                ->andWhere(['question.status' => 1]) // Faqat faol savollar
                ->orderBy(new Expression('rand()')) // Tasodifiy tartib
                ->limit($this->old_test_count) // old_test_count bo'yicha cheklash
                ->all();
        }
        // Agar eski test savollari bo'lsa, yangi savollarni ham qo'shish
        if (!empty($old_questions)) {
            // Yangi savollarni olish
            $new_questions = $this->getQuestions()
                ->andWhere(['status' => 1]) // Faqat faol savollar
                ->orderBy(new Expression('rand()')) // Tasodifiy tartib
                ->limit($this->current_test_count) // current_test_count bo'yicha cheklash
                ->all();
            // Eski va yangi savollarni birlashtirish
            $result = array_merge($new_questions, $old_questions);
        } else {
            // Faqat joriy test savollarini olish
            $result = $this->getQuestions()
                ->andWhere(['status' => 1]) // Faqat faol savollar
                ->orderBy(new Expression('rand()')) // Tasodifiy tartib
                ->limit($this->tests_count) // tests_count bo'yicha cheklash
                ->all();
        }

        return $result;
    }


    /**
     * @return string
     */
    public function getFormattedPrice()
    {
        if ($this->is_free) {
            return Yii::t('app', 'Free');
        }
        return Yii::$app->formatter->asInteger((int)$this->price) . " so'm";
    }

    public function getNameAndPrice()
    {
        return $this->name . ' (' . $this->getFormattedPrice() . ')';
    }

    public static function paymetMap(): array
    {
        return ArrayHelper::map(self::find()->andWhere(['status' => Test::STATUS_ACTIVE])->andWhere(['is_free' => 0])->all(), 'id', 'name');
    }

    public function getTestEnroll()
    {
        // Subquery to calculate the count
        $subQuery = TestResult::find()
            ->alias('tr')
            ->select([
                'tr.test_id',
                'IFNULL(count(*), 0) as count'  // IFNULL to handle potential NULL counts
            ])
            ->groupBy('tr.test_id');

        return TestEnroll::find()
            ->alias('te')  // Alias for the main table
            ->where(['te.test_id' => $this->id])
            ->leftJoin(
                ['tr' => $subQuery],
                'tr.test_id = te.test_id'
            )
            ->andWhere(['>', 'te.count', new \yii\db\Expression('tr.count')]) // Adjusted to compare with IFNULL(te.count, 0)
            ->one();
    }


}
